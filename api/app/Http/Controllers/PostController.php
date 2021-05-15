<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\Post\CreateRequest as CreatePostRequest;
use App\Http\Resources\Post as PostResource;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Create a post
     *
     * @param CreatePostRequest $request
     * @return PostResource|\Illuminate\Http\JsonResponse
     */
    public function store(CreatePostRequest $request)
    {

        $slug = Str::slug($request->title);
        $duplicate = Post::where('slug', $slug)->first();

        //since the slug should be unique
        if ($duplicate)
        {
            return response()->json([
                'errors' => [
                    'title' => 'Title already exists.'
                ]
            ], 409);
        }

        $post = new Post;
        $post->title = $request->title;
        $post->slug = $slug;

        //storing the picture
        if ($request->featured)
        {
            $filename = $slug. '-' .$request->featured->getClientOriginalName();
            $request->featured->storeAs('posts/featured', $filename, 'public');
            if($request->featured){
                $post->featured = $filename;
            }
        }

        $post->excerpt = $request->excerpt;
        $post->body = $request->body;
        $post->active = $request->active;

        if ($request->active)
        {
            $post->published_at = now();
        }

        $post->author()->associate($request->user());
        $post->save();

        return  new PostResource($post);
    }


}
