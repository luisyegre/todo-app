<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthCredentialsValidator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthCredentialsValidator $request){
        try {

            $user = User::where('email',$request->input("email"))->first();

            if($user == null){
                return response()->json([
                    'message'=>'Usuario no registrado'
                ],404);
            }
            Auth::attempt($request->only('email','password'));
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'message'=>'Logeado',
                'token'=>$token,
                'token_type'=>'bearer',
                'user'=>$user
            ]);
        } catch(\Exception $e){
            return response()->json([
                'message'=>'Something went wrong',
                'user'=>$e->getMessage()
            ]);
        }
    }

}
