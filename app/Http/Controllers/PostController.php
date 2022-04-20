<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function index()
    {

        $post = Post::with(['comments', 'user', 'tags']);

        return PostsResource::collection($post->paginate(5));
    }



    public function store(Request $request, User $user)
    {

        $request->validate([

            'title' => 'required|unique:posts|max:255',
            'content' => 'required',
        ]);

        $post = DB::transaction(function () use ($request, $user) {

            $post = Post::create([

                'user_id' => $user->id,
                'title' => $request->title,
                'content' => $request->content,
            ]);

            $post->tags()->sync($request->tag_id);

            return $post;

        });

        return new PostsResource($post);
    }



    public function show(Post $post)
    {

        return new PostsResource($post);
    }



    public function update(Request $request, Post $post, User $user)
    {

        $request->validate([

            'title' => 'required|max:255',
            'content' => 'required',
        ]);


        $post = DB::transaction(function () use ($post, $request) {

            $post->update([

                'title' => $request->title,
                'content' => $request->content,
            ]);

            $post->tags()->sync($request->tag_id);

            return $post;

        });

        return new PostsResource($post);

    }


    public function destroy(Post $post)
    {
        $post->delete();

        return response(null, 204);
    }

}
