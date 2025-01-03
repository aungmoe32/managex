<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Subject;
use App\Constants\Constant;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Permissions\Permissions;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\SubjectResource;
use App\Mail\PostPosted;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{

    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewAnyPost = auth()->user()->can('viewAny', Post::class);
        $filters = [
            'title',
            $viewAnyPost ? AllowedFilter::exact('publish') : null,
            AllowedFilter::exact('user.id'),
            AllowedFilter::exact('category_id'),
            'category.name',
            'comments.content'
        ];
        $query = QueryBuilder::for(Post::class)
            ->allowedFilters(array_filter($filters))
            ->defaultSort(['-created_at']) // newest posts
            ->allowedSorts(['title', 'publish', 'category_id', 'created_at'])
            ->allowedIncludes(['comments', 'user'])
            ->with(['medias', 'category']);

        if (!$viewAnyPost) $query
            ->where('publish', 1);
        $posts = $query
            ->paginate(Constant::PageSize);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();
        if ($user->can('create', Post::class)) {
            $post = $user->posts()->create($validated);
            if ($request->hasFile('medias')) {
                foreach (request('medias') as $file) {
                    $post
                        ->addMedia($file)
                        ->toMediaCollection('medias', 's3');
                }
            }
            if ($post->publish) {
                $users = $post->category->users;
                Mail::to($users)->queue(new PostPosted($post));
            }
            return $this->ok('Post Created');
        }
        return $this->notAuthorized('not authorized');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Cache::remember("posts:{$id}", 60 * 60, function () use ($id) {
            $post = QueryBuilder::for(Post::class) // base query instead of model
                ->allowedIncludes(['user'])
                ->with(['category', 'medias'])
                ->findOrFail($id); // we only need one specific user
            return $post;
        });
        Redis::zincrby('trending_posts', 1, $id);

        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $user = Auth::user();
        if ($user->can('update', $post)) {
            $post->update($request->validated());
            return $post;
        }

        return $this->notAuthorized('Not authorized');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $user = Auth::user();
        if ($user->can('delete', $post)) {
            $post->delete();
            return $this->success('Post Deleted');
        }
        return $this->notAuthorized('Not authorized');
    }


    /**
     * Get trending posts
     */
    public function trending()
    {
        $trending = Redis::zrevrange('trending_posts', 0, 5);
        $data = Post::with(['medias', 'user', 'category'])->find($trending);

        // Create an associative array for quick lookup
        $dataById = [];
        foreach ($data as $item) {
            $dataById[$item['id']] = $item;
        }

        // Reorder the data based on the order array
        $reorderedData = array_map(function ($id) use ($dataById) {
            return $dataById[$id];
        }, $trending);
        // return $trending;
        return PostResource::collection($reorderedData);
    }
}
