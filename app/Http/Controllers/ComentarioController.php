<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComentarioRequest;
use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(ComentarioRequest $comentarioRequest, User $user, Post $post)
    {
        $data = $comentarioRequest->validated(); 

         Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $data['comentario']
        ]); 

        return [
            'message' => 'Comentario Agregado'
        ]; 


    }
}
