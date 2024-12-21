<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\File;
use App\Utils\VideoStream;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateMediaRequest;

class MediaController extends Controller
{
    use ApiResponses;

    // creating medias
    public function store(CreateMediaRequest $request, Post $post)
    {
        $user = Auth::user();
        if ($user->can('update', $post)) {
            if ($request->hasFile('medias')) {
                foreach (request('medias') as $file) {
                    $post
                        ->addMedia($file)
                        ->toMediaCollection('medias');
                }
            }
            return $this->ok('Medias Created');
        }
        return $this->notAuthorized('Not authorized');
    }

    // showing medias
    public function show($id, $filename)
    {

        // Define the private path
        $path = storage_path("app/{$id}/{$filename}");

        // Check if the file exists
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        // stream if file is video
        $file = new File($path);
        if (str_starts_with($file->getMimeType(), 'video/')) {
            $stream = new VideoStream($path);
            $stream->start();
            return;
        }

        // Return the file as a response
        return response()->file($path);
    }
}
