<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\ProfileEditRequest;
use App\Http\Resources\ProfileUserCollection;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        //Se necesita esta forma para poder paginar 
        //$posts = Post::where('user_id', $user->id)->get(); 

        if($user){
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username'=> $user->username,
                'posts' => $user->posts, 
                'image' => $user->image,
                'numPosts' => $user->posts->count(),
                'NumberFollowers' => $user->followers->count(),
                'NumberFollowings' => $user->followings->count(),
            ];
        }
        //return response()->json(['message' => 'Usuario no encontrado'], 404);
    }


    public function editProfile(ProfileEditRequest $request)
    {
        $data = $request->validated();

        $user = User::find(auth()->user()->id);
        $user->username = $data['username'];  


       if($request->file('image')){
            $image = $request->file('image'); 
            $nameImage = Str::uuid() . "." . $image->extension(); 
            $imageServer = Image::make($image);
            $imageServer->fit(1000,1000); 
            $imagePath = public_path('profiles') . '/' . $nameImage; 
            $imageServer->save($imagePath); 

            if($user->image){
                $image_path = public_path('profiles/' . $user->image); 
                if(File::exists($image_path)){
                 unlink($image_path);
                }
            }
        }            

        $user->image = $nameImage ?? auth()->user()->image ?? null;
        $user->save();  

        return [
            'message' => 'Perfil Editado',
            'user' => $user,
           // 'datos' => $request->username,
            //'image' => $request->image
        ];
    }
}
