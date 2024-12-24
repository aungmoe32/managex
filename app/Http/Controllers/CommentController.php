<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {

        $viewAny = auth()->user()->can('viewAny', Comment::class);
        if ($viewAny) {
            $query = QueryBuilder::for(Comment::class)
                ->allowedFilters(['content'])
                ->defaultSort(['-created_at']) // newest cmts
                ->allowedSorts(['created_at'])
                ->where('post_id', $post->id)
                ->with(['user']);

            $posts = $query
                ->paginate(10);
            return CommentResource::collection($posts);
        }
        return $this->notAuthorized();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post, StoreCommentRequest $request)
    {
        $user = auth()->user();
        if ($user->can('create', Comment::class)) {
            $post->comments()->create([
                'user_id' => $user->id,
                'content' => $request->validated('content')
            ]);
            return $this->success('Comment created');
        }
        return $this->notAuthorized();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $user = Auth::user();
        if ($user->can('update', $comment)) {
            $comment->update($request->validated());
            return $this->success('Comment Updated');
        }

        return $this->notAuthorized('Not authorized');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
