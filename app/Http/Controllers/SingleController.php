<?php

namespace App\Http\Controllers;

use App\Models\Post;


class SingleController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post
            ->comments()
            ->latest()
            ->paginate(15);
        //dd($comments->all());

        return view('single', compact('post','comments'));

    }
}
