<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentsResorce;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    //
    public function index () {
        return CommentsResorce::collection(Comment::all());
    }

    public function store (Request $request, Post $post) {

        $comment = Comment::create([
            'post_id' => $post->id,
            'body' => $request->body
        ]);

        return new CommentsResorce($comment);
    }

    public function shows(Comment $comment) {

        return new CommentsResorce($comment);

    }
}
