<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    public function index()
    {
        $posts = Post::with("user", "comments.user", "medias", "likes.user", "categories")->orderBy('created_at', 'desc')->get();
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
            $image_path = $ct->store('image', 'public');
            $medias->content = $image_path;
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

    /*public function update(Request $request, Post $post)
    {
        $input = $request->all();

        $PostData = [
            "description" => $request["description"],
            "user_id" => Auth::user()->id
        ];
        die(print_r($input));

        $validator = Validator::make($input, [
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $post->description = $PostData["description"];
        $post->save($PostData);
        $category = Category::find($request["category_id"]);
        $post->categories()->attach($category);
        foreach ($request->content as $ct) {
            $medias = new Media;
            $image_path = $ct->store('image', 'public');
            $medias->content = $image_path;
            $post->medias()->save($medias);
        }

        return $this->sendResponse(new PostResource($post), 'Post updated successfully.', 200);

    }*/

    public function destroy(Post $post)
    {
        if(Auth::user()->id == $post->user_id){
            $post->delete();
            return $this->sendResponse([], 'Post deleted successfully.', 202);
        }else{
            return $this->sendError('Invalid credentials.', ['error' => "Post doesn't belongs to this user"]);
        }
        
    }

    public function getAuthPosts()
    {
        $user = User::with('posts.categories')->find(Auth::user()->id);
        $posts = $user->posts;
        return $this->sendResponse(new PostResource($posts), 'Posts retrieved successfully.', 200);
    }

    public function getUserPosts($user_id)
    {
        $posts = Post::with("user", "comments.user", "medias", "likes.user", "categories")->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();
        return $this->sendResponse(PostResource::collection($posts), 'User posts retrieved successfully.', 200);
    }
}
