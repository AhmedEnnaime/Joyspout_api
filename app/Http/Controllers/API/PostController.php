<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    public function index()
    {
        $categories = Post::all();
        return $this->sendResponse(PostResource::collection($categories), 'Posts retrieved successfully.', 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        die($request["description"]);

        $validator = Validator::make($input, [
            'description' => 'required',

        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
    }
}
