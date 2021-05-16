<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\Post\CreateRequest as CreatePostRequest;
use App\Http\Requests\Post\UpdateRequest as UpdatePostRequest;
use App\Http\Resources\Post as PostResource;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Get all posts
     *
     * @return mixed
     */
    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return PostResource::collection($posts);
    }

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
        $post->excerpt = $request->excerpt;
        $post->body = $request->body;
        $post->active = $request->active;

        //storing the picture
        if ($request->featured)
        {
            $filename = $slug. '-' .$request->featured->getClientOriginalName();
            $request->featured->storeAs('posts/featured', $filename, 'public');
            if($request->featured){
                $post->featured = $filename;
            }
        }

        if ($request->active)
        {
            $post->published_at = now();
        }

        $post->author()->associate($request->user());
        $post->save();

        return  new PostResource($post);
    }

    /**
     * Handling the update request
     *
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return PostResource
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->excerpt = $request->excerpt;
        $post->body = $request->body;
        $post->active = $request->active;

        if ($request->featured)
        {
            $filename = $post->slug. '-' .$request->featured->getClientOriginalName();
            $request->featured->storeAs('posts/featured', $filename, 'public');
            if($request->featured){
                $post->featured = $filename;
            }
        }

        if ($request->active)
        {
            $post->published_at = now();
        }

        $post->save();

        return  new PostResource($post);
    }

    /**
     * Handles the delete request
     *
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response(null, 204);
    }

}
