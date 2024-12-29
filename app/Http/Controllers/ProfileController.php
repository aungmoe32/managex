<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Resources\OwnProfileResource;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    use ApiResponses;

    /**
     * Display the my profile.
     */

    public function me()
    {
        $user = auth()->user();
        $user->roles;
        $user->categories;
        $user->favourites;
        return OwnProfileResource::make($user);
    }

    /**
     * Update Email
     */
    public function updateEmail(UpdateEmailRequest $request)
    {
        $user = auth()->user();
        $user->email = $request->safe()->email;
        $user->email_verified_at = null;
        $user->save();
        return $this->success('Updated');
    }

    /**
     * Update the my profile
     */
    public function updateMe(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        if ($user->can('update', $user->profile)) {
            $data = [];
            if ($request->has('bio')) $data['bio'] = $request->input('bio');
            if ($request->hasFile('image')) {
                $user->profile
                    ->addMediaFromRequest('image')
                    ->toMediaCollection('profile');
            }
            if ($request->has('name')) $user->update($request->safe()->only('name'));
            $user->profile()->update($data);
            if ($request->has('categories')) {
                $user->categories()->detach();
                $user->categories()->attach($request->validated('categories'));
            }
            return $this->success('profile updated');
        }
        return $this->notAuthorized('You are not authorized to update that resource');
    }
    /**
     * User stats
     */
    public function stats()
    {
        $user = auth()->user();
        return Redis::hgetall("user:{$user->id}:stats");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
