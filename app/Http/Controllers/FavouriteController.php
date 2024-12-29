<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class FavouriteController extends Controller
{
    use ApiResponses;
    function addToFavourites(Post $post)
    {
        $user = auth()->user();
        $user->favourites()->attach($post->id);
        Redis::hincrby("user:{$user->id}:stats", 'favourites', 1);
        return $this->success("Added to favourites");
    }

    public function removeFromFavourites(Post $post)
    {
        $user = auth()->user();
        $user->favourites()->detach($post->id);
        Redis::hincrby("user:{$user->id}:stats", 'favourites', -1);
        return $this->success("Removed from favourites");
    }

    public function getFavourites()
    {
        $user = auth()->user();
        $favourites = $user->favourites;
        return $this->success(PostResource::collection($favourites));
    }
}
