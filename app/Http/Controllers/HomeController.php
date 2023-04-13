<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        
        $idsFollowings = auth()->user()->followings->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $idsFollowings)->latest()->get();

        foreach ($posts as $post) {
            $posts->user = $post->user;
        }

        return [
            'posts' => $posts,
        ];

    }
}
