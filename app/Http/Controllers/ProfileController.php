<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmailRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\OwnProfileResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponses;

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
        return OwnProfileResource::make($user);
    }

    /**
     * Display the my profile.
     */

    public function updateEmail(UpdateEmailRequest $request)
    {
        $user = auth()->user();
        // $user->update($request->validated());
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
            // dd(request()->has('bio'));
            if ($request->has('bio')) $data['bio'] = $request->input('bio');
            if ($request->hasFile('image')) {
                // dd(url($user->profile->image_file));
                $user->profile
                    ->addMediaFromRequest('image')
                    ->toMediaCollection('profile');
            }
            $user->profile->update($data);
            return $this->success('profile updated');
            // return $user;
        }
        return $this->notAuthorized('You are not authorized to update that resource');
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
