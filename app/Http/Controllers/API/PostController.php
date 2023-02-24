<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    public function index()
    {
        $posts = Post::with("user", "comments.user", "medias", "likes.user")->get();
        return $this->sendResponse(PostResource::collection($posts), 'Posts retrieved successfully.', 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $PostData = [
            "description" => $request["description"],
            "user_id" => Auth::user()->id
        ];

        $validator = Validator::make($input, [
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $post = Post::create($PostData);

        $category = Category::find($request["category_id"]);

        $post->categories()->attach($category);

        foreach ($request->content as $ct) {
            $medias = new Media;

            $fileName = time() . $ct->getClientOriginalName();
            $ct->move(public_path('uploads'), $fileName);
            $medias->content = $fileName;
            $post->medias()->save($medias);
        }

        return $this->sendResponse(new PostResource($post), 'Post created successfully.', 201);
    }

    public function show($id)
    {
        $post = Post::find($id);

        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }

        return $this->sendResponse(new PostResource($post), 'Post retrieved successfully.', 200);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return $this->sendResponse([], 'Post deleted successfully.', 202);
    }

    /*public function getPostComments($post_id)
    {
        $post = Post::find($post_id);
        $comments = $post->comments;
        return $this->sendResponse(new CommentsResource($comments), 'Comments retrieved successfully.', 200);
    }*/
}
