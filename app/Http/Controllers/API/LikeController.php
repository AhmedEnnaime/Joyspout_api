<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\LikesResource;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends BaseController
{
    public function index($id)
    {
        $post = Post::find($id);
        $post->likes()->create(["user_id" => Auth::user()->id, "post_id" => $post->id]);
        return $this->sendResponse(new LikesResource($post), 'Like created successfully.', 201);
    }

    public function deleteLike($id)
    {
        $like = Like::findOrFail($id);
        if ($like->user_id == Auth::user()->id) {
            $like->delete();
            return $this->sendResponse([], 'Like deleted successfully.', 202);
        } else {
            return $this->sendError('Invalid credentials.', ['error' => "Like doesn't belongs to this user"]);
        }
    }
}
