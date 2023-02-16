<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use App\Models\Post;

class MediaController extends BaseController
{
    public function index($id)
    {
        $post = Post::find($id);
        $medias = $post->medias()->get();
        return $this->sendResponse(MediaResource::collection($medias), 'Medias retrieved successfully.', 200);
    }
}
