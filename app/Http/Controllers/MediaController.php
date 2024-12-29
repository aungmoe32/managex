<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\File;
use App\Utils\VideoStream;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateMediaRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    use ApiResponses;

    // creating medias
    public function store(CreateMediaRequest $request, Post $post)
    {
        $user = Auth::user();
        $media = null;
        if ($user->can('update', $post)) {
            if ($request->hasFile('medias')) {
                foreach (request('medias') as $file) {
                    $media = $post
                        ->addMedia($file)
                        ->toMediaCollection('medias');
                }
            }
            return $this->ok('Medias Created', [
                'id' => $media->id
            ]);
        }
        return $this->notAuthorized('Not authorized');
    }

    // deleting medias
    public function destroy(Post $post, $media_id)
    {
        $user = Auth::user();
        if ($user->can('update', $post)) {
            $post->deleteMedia($media_id);
            return $this->ok('Media Deleted');
        }
        return $this->notAuthorized('Not authorized');
    }

    // showing medias
    public function show($id, $filename)
    {
        // $media = Media::find($id);
        // $post = $media->model;
        // $user = Auth::user();
        // if (!$user->can('view', $post)) {
        //     return $this->notAuthorized('Not authorized');
        // }

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

    // showing profile images
    public function profile($id, $filename)
    {

        // Define the private path
        $path = storage_path("app/{$id}/{$filename}");

        // Check if the file exists
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }


        // Return the file as a response
        return response()->file($path);
    }

    // Download Media From S3
    public function download($id, $filename)
    {
        Redis::incr("medias:{$id}:downloads");
        return Storage::disk('s3')->download("/{$id}/{$filename}");
    }
}
