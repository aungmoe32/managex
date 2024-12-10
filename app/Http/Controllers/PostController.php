<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subject;
use App\Constants\Constant;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\SubjectResource;

class PostController extends Controller
{

    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters(['title', AllowedFilter::exact('publish'), AllowedFilter::exact('category_id'), 'category.name', 'comments.content'])
            ->allowedIncludes(['comments'])
            ->with(['medias', 'category'])
            ->paginate(Constant::PageSize);

        return $posts;
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
                        ->toMediaCollection('medias');
                }
            }
            return $this->ok('Post Created', $post);
        }
        return $this->notAuthorized('not authorized');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
