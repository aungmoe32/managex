<div class="email-container">
    <div class="email-header">
        <h1>Congratulations! 🎉</h1>
    </div>
    <div class="email-body">
        <p>Hi {{ $user->name }},</p>
        <p>Your comment on the post "<strong>{{ $post->title }}</strong>" has been marked as the <strong>Best
                Comment</strong>!</p>
        <blockquote style="margin: 20px 0; padding: 10px; background: #f7f7f7; border-left: 4px solid #4CAF50;">
            {{ $comment->content }}
        </blockquote>
        <p>Thank you for contributing to the discussion and sharing your valuable insights!</p>
        <a href="{{ url('/api/posts/' . $post->id) }}" class="button">View Post</a>
    </div>
</div>
