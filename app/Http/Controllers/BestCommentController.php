<?php

namespace App\Http\Controllers;

use App\Actions\MarkBestComment;
use App\Models\Comment;
use App\Permissions\Permissions;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class BestCommentController extends Controller
{
    use ApiResponses;

    public function mark(Comment $comment, MarkBestComment $action)
    {
        $user = auth()->user();
        if ($user->can(Permissions::CRUDAnyComment)) {
            if ($comment->best) return $this->error(['Already marked']);
            $comment->update([
                'best' => true
            ]);
            $action->handle($comment);
            return $this->success('Marked');
        }
        return $this->notAuthorized();
    }

    public function unmark(Comment $comment)
    {
        $user = auth()->user();
        if ($user->can(Permissions::CRUDAnyComment)) {
            $comment->update([
                'best' => false
            ]);
            return $this->success('Unmarked');
        }
        return $this->notAuthorized();
    }
}
