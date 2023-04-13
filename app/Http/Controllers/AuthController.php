<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller

{
    public function login(LoginRequest $request){
        //Validar 
        $data = $request->validated(); 

        //Revisar Password
        if(!Auth::attempt($data)){
            return response([
                'errors' => ['El email o el password son incorrectos']
            ], 422);
        }

        //Autenticar al Usuario 
        $user = Auth::user();
        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }//fin Login

    public function register(RegisterRequest $request)
    {

    //$request->request->add(['username' => Str::slug($request->username)]); 


    //Validar el Registro 
    $data = $request->validated(); 

    //Create User 
    $user = User::create([
        'name' => $data['name'], 
        'username' => $data['username'],
        'email' => $data['email'], 
        'password' => bcrypt($data['password']),
    ]);

    //Return Response 
    return [
        'token' => $user->createToken('token')->plainTextToken,
        'user' => $user
    ];
    

}//fin Register 

public function logout(Request $request)
{
    //Revocar Token 
    $user = $request->user();
    $user->currentAccessToken()->delete(); 
    return [
        'user' => null
    ];
}


}//fin de la clase 
