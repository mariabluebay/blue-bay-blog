<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Post;
use App\Access;
use App\User;
use App\Http\Requests\Post\CreateRequest as CreatePostRequest;
use App\Http\Requests\Post\UpdateRequest as UpdatePostRequest;
use App\Http\Resources\Post as PostResource;
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Get latest posts that are visible for public or friends
     *
     * @return mixed
     */
    public function index()
    {
        $posts = Post::latest()->with('author')->paginate(5);
        $filtered = $posts->whereIn('audience', ['public']);
        return PostResource::collection($filtered);
    }

    /**
     * Returns a post based on it slug
     *
     * @param $slug
     * @return PostResource
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->with('author')->firstOrFail();
        return  new PostResource($post);
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
        $post->featured = $this->storeFile($request->featured, $post->slug);

        if ($request->active)
        {
            $post->published_at = now();
        }

        $post->author()->associate($request->user());

        $access = new Access();
        $access->user()->associate($request->user());
        $access->accessible_for = $request->audience;

        $post->save();

        $post->audience()->save($access);

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

        $post->excerpt = $request->get('excerpt', $post->excerpt);
        $post->body = $request->get('body', $post->body);
        $post->active = $request->get('active', $post->active);

        if($request->featured){
            $post->featured = $this->storeFile($request->featured, $post->slug);
        }

        if ($post->active)
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
        Helper::deleteFile($post->featured, 'posts/featured/');
        $post->delete();
        return response(null, 204);
    }

    /**
     * Handles the featured post image storage
     *
     * @param $file
     * @param $slug
     * @return string|null
     */
    public function storeFile($file, $slug)
    {
        $filename = null;
        if ($file)
        {
            $filename = $slug. '-' .$file->getClientOriginalName();
            $file->storeAs('posts/featured', $filename, 'public');
        }
        return $filename;
    }

    /**
     * Get user's timeline
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function timeline(User $user) {

        if( $user->id !== auth()->user()->id ) {
            $posts = $user->publicTimeline();
        } else {
            $posts = $user->timeline();
        }

        return PostResource::collection($posts);
    }
}
