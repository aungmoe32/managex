<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use App\Utils\VideoStream;
use Illuminate\Http\Request;

class MediaController extends Controller
{
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
