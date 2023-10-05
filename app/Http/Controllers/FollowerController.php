<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function index(User $user)
    {
       $siguiendo = $user->siguiendo(auth()->user());
       return [
        'siguiendo' => $siguiendo
       ];

    }
    public function store(User $user)
    {
        $user->followers()->attach(auth()->user()->id); 
        return [
            "message" => "Has comenzado a seguir al Usuario"
        ];
    }

    public function destroy(User $user)
    {
        $user->followers()->detach( auth()->user()->id ); 
        return [
            "message" => "Has dejado de seguir al Usuario"
        ];
    }

    public function following(User $user)
    {
        if(!$user){
            return response(404)->json("Not found");
        }
        
        $ids = $user->followings->pluck('id')->toArray();
        $followings = User::whereIn('id', $ids)->latest()->get(); 
        return [
            'followings' => $followings
        ];
    }

    public function followers(User $user)
    {
        $ids = $user->followers->pluck('id')->toArray();
        $followers = User::whereIn('id', $ids)->latest()->get(); 

        return [
            'followers' => $followers
        ];
    }

}
