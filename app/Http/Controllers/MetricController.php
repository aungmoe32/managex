<?php

namespace App\Http\Controllers;

use App\Constants\Role;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MetricController extends Controller
{
    use ApiResponses;
    function index()
    {

        $data = [
            'users' => [
                "total" => User::count(),
                'roles' => [
                    'admins' => User::whereHas('roles', function (Builder $query) {
                        $query->where('name', Role::ADMIN);
                    })->count(),
                    'users' => User::whereHas('roles', function (Builder $query) {
                        $query->where('name', Role::USER);
                    })->count(),
                ]
            ],
            'posts' => [
                'total' => Post::count(),
                'published' => Post::where('publish', 1)->count(),
                'categories' => CategoryResource::collection(Category::withCount('posts')->get())
            ],
            'comments' => [
                'total' => Comment::count(),
            ],
            'media' => [
                'total_files' => Media::count(),
            ]
        ];
        return $this->success('success', $data);
    }
}
