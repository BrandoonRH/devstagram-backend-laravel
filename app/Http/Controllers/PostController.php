<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\File;
use App\Exceptions\MyModelNotFoundException;

class PostController extends Controller
{
    
    public function index(Post $post)
    {
            if($post){
              $comentariosPost = []; 

                //$comentariosPost = $post->comentarios()->get();

                foreach ($post->comentarios as $comentario) {
                    $comentariosPost[] = [
                            'id' => $comentario->id,
                            'comentario' => $comentario->comentario,
                            'created_at' => $comentario->created_at,
                            'usernameComentario' => $comentario->user->username
                    ];
                }

                return [
                    'comentariosPost' => $comentariosPost,
                ]; 
            }
    }


    public function create()
    {
        //Retornaria una Vista
    }

    public function store(PostRequest $postRequest)

    {
        $data = $postRequest->validated(); 
        
       /*Post::create([
            'title' => $postRequest->title, 
            'description' => $postRequest->description,
            'image' => $postRequest->image,
            'user_id' => auth()->user()->id   
        ]);*/

        /*$post = new Post; //Otra forma de gusradar el registro 
        $post->title = $postRequest->title; 
        $post->description = $postRequest->description; 
        $post->image = $postRequest->image;
        $post->user_id = auth()->user()->id;   
        $post->save();*/

        //Otra forma de almacenar ahora con relaciones 

        $postRequest->user()->posts()->create([
            'title' => $postRequest->title, 
            'description' => $postRequest->description,
            'image' => $postRequest->image,
            'user_id' => auth()->user()->id   
        ]);

        return response()->json(['message' => 'Post Creado']);
    }


    public function show(User $user, Post $post)
    {
        if(!$post){
            throw new MyModelNotFoundException();
        }

        $userPost = User::where('id', $post->user_id)->latest()->get(); 
        return [
            'post' => $post,
            'userPost' => $userPost,
        ];
       
    }

    public function destroy(Post $post)
    {
           $this->authorize('delete', $post); 
           $post->delete(); 
           //Eliminar Image Post
           $image_path = public_path('uploads/' . $post->image); 
           if(File::exists($image_path)){
            unlink($image_path);
           }
           return [
                "message" => "Post Eliminado"
           ]; 
    }
}
