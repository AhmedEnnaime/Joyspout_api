<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\PostCategoryResource;
use App\Models\Post;

class PostCategoryController extends BaseController
{
    public function index($id)
    {
        $post = Post::find($id);
        $categories = $post->categories()->get();
        return $this->sendResponse(new PostCategoryResource($categories), 'Categories retrieved successfully.', 200);
    }
}
