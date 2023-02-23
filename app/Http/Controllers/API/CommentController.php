<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentsResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CommentController extends BaseController
{
    public function createComment(Request $request, $post_id)
    {
        $post = Post::find($post_id);
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::user()->id;
        $post->comments()->save($comment);
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
