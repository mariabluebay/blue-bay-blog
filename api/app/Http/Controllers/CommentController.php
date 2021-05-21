<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\Comment\CreateRequest;
use App\Http\Resources\Comment as CommentResource;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CreateRequest $request)
    {

        $post =  Post::where('slug', $request->slug)->firstorFail();

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->post()->associate($post);
        $comment->user()->associate($request->user());
        $comment->save();

        return new CommentResource($comment);

    }

}
