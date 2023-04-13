<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function index(Post $post)
    {
        $numLiks = $post->likes->count();
        if($post->checkLike(auth()->user())){
            
            return [
                "userLike" => true,
                "numLikesPost" => $numLiks 
            ]; 
        }else{
           
            return [
                "userLike" => false,
                "numLikesPost" => $numLiks 
            ]; 
        }
    }

    public function store(Post $post)
    {
        if($post->checkLike(auth()->user())){

        }else{
            $post->likes()->create([
                'user_id' => auth()->user()->id  
            ]); 
    
            return [
                "messages" => "Diste Like"
            ]; 
        }
       
    }

    public function destroy(Request $request, Post $post)
    {

        $request->user()->likes()->where('post_id', $post->id)->delete(); 
        return [
            "messages" => "Quitaste Like"
        ]; 
    }
}

