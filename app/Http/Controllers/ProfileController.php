<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $user->all_permissions = $user->getAllPermissions();
        return $user;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    public function show()
    {
        $user = auth()->user();
        $user->profile->image_url = $user->profile->getFirstMedia('profile')->getUrl();
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        if ($user->can('update', $user->profile)) {
            $data = [];
            if ($request->has('bio')) $data['bio'] = $request->input('bio');
            if ($request->hasFile('image')) {
                // dd(url($user->profile->image_file));
                $user->profile
                    ->addMediaFromRequest('image')
                    ->toMediaCollection('profile');
            }
            $user->profile->update($data);
            return $user;
        }
        return $this->notAuthorized('You are not authorized to update that resource');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
