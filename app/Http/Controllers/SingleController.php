<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SingleController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post
            ->comments()
            ->latest()
            ->paginate(15);
        //dd($comments->all());

        return view('single', compact('post', 'comments'));

    }

    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'text' => 'required'
        ]);
        $post->comments()->create([
            'user_id' => Auth::id(),
            'text' => $request->input('text'),
        ]);
        return ['created' => true];

    }
}
