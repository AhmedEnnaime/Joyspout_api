<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentsResource;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CommentController extends BaseController
{
    public function createComment(Request $request, $post_id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $data = [
            "content" => $request->content,
            "post_id" => $post_id,
            "user_id" => Auth::user()->id,
        ];

        $comment = Comment::create($data);
        return $this->sendResponse(new CommentsResource($comment), 'Comment created successfully.', 201);
    }

    public function deleteComment($id)
    {

        $comment = Comment::findOrFail($id);
        if ($comment->user_id == Auth::user()->id) {
            $comment->delete();
            return $this->sendResponse([], 'Comment deleted successfully.', 202);
        } else {
            return $this->sendError('Invalid credentials.', ['error' => "Comment doesn't belongs to this user"]);
        }
    }

    public function updateComment(Request $request, $comment_id)
    {
        $input = $request->all();
        $comment = Comment::find($comment_id);
        $validator = Validator::make($input, [
            'content' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if ($comment->user_id == Auth::user()->id) {
            $comment->content = $request->content;
            $comment->post_id = $comment->post_id;
            $comment->user_id = Auth::user()->id;
            $comment->save();
            return $this->sendResponse(new CommentsResource($comment), 'Comment updated successfully.', 200);
        } else {
            return $this->sendError('Invalid credentials.', ['error' => "Comment doesn't belongs to this user"]);
        }
    }
}
