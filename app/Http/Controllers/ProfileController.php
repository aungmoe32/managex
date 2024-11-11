<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show() {}

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
        if (auth()->user()->can('update', auth()->user()->profile)) {
            $data = [];
            if ($request->has('bio')) $data['bio'] = $request->input('bio');
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('public/images');
                $data['image_file'] = $path;
            }
            auth()->user()->profile->update($data);
            return auth()->user();
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
