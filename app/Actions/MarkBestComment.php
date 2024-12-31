<?php

namespace App\Actions;

use App\Mail\BestComment;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;

class MarkBestComment
{
    public function handle(Comment $comment)
    {
        Mail::to($comment->user)->queue(new BestComment($comment));
    }
}
