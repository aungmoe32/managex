<h1>
    {{ $post->title }}
</h1>
<p>
    New post uploaded! You might like it.
</p>
<p>
    <a href="{{ url('/api/posts/' . $post->id) }}">See Post</a>
</p>
