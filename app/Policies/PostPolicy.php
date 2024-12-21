<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Permissions\Permissions;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->can(Permissions::CRUDAnyPost)) return true;

        // check filter[user.id] is logged in user
        $filters = request()->query('filter', []);
        if (is_array($filters) && array_key_exists('user.id', $filters)) {
            return (auth()->user()->id == $filters['user.id']);
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        if ($post->publish) {
            return true;
        }
        if ($user->can(Permissions::CRUDAnyPost)) {
            return true;
        }
        if ($user->can(Permissions::CRUDOwnPost)) {
            return $user->id == $post->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can(Permissions::CRUDOwnPost)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        //
        if ($user->can(Permissions::CRUDAnyPost)) {
            return true;
        }
        if ($user->can(Permissions::CRUDOwnPost)) {
            return $user->id == $post->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->can(Permissions::CRUDAnyPost)) {
            return true;
        }
        if ($user->can(Permissions::CRUDOwnPost)) {
            return $user->id == $post->user_id;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        //
    }
}
