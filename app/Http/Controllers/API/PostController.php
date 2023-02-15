<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\MediaResource;
use App\Http\Resources\PostResource;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    public function index()
    {
        $posts = Post::all();
        //$posts = Post::select("posts.*", "medias.content as media")->join('medias', 'posts.id', '=', 'medias.post_id')->get();
        return $this->sendResponse(PostResource::collection($posts), 'Posts retrieved successfully.', 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $PostData = [
            "description" => $request["description"],
            "user_id" => $request["user_id"]
        ];

        //die(print_r($request["content"]));


        $validator = Validator::make($input, [
            'description' => 'required',
            'user_id' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $post = Post::create($PostData);



        foreach ($request["content"] as $post_content) {
            $MediaData = [
                "content" => $post_content,
                "post_id" => $post->id
            ];
            die(print_r($MediaData));
            $media = Media::create($MediaData);
        }


        return $this->sendResponse([new PostResource($post), new MediaResource($media)], 'Post created successfully.', 201);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return $this->sendResponse([], 'Post deleted successfully.', 202);
    }
}
