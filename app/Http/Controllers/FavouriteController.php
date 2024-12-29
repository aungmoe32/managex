<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    use ApiResponses;
    function addToFavourites(Post $post)
    {
        $user = auth()->user();
        $user->favourites()->attach($post->id);
        return $this->success("Added to favourites");
    }

    public function removeFromFavourites(Post $post)
    {
        $user = auth()->user();
        $user->favourites()->detach($post->id);
        return $this->success("Removed from favourites");
    }

    public function getFavourites()
    {
        $user = auth()->user();
        $favourites = $user->favourites;
        return $this->success($favourites);
    }
}
