<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try{
            if(Auth::attempt($request->only('email','password'))){
                /** @var User $user */
                $user = Auth::user();
                $token = $user->createToken('app')->accessToken;
    
                return response([
                    'message' => 'successfully logged in',
                    'token' => $token,
                    'user' => $user
                ]);
            }

        }catch(\Exception $exception){
            return response([
                'message' => $exception->getMessage()
            ],400);

        }
        
        return response([
            'message' => 'Invalid username/password'
        ],401);
    }

    public function user()
    {
        return Auth::user();
    }

    public function register(RegisterRequest $request)
    {
        try{
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            return $user;

        }catch(\Exception $exception)
        {
            return response([
                'message' => $exception->getMessage()
            ],400);
        }
        
    }
    public function logout(Request $request)
    {
        // auth()->user()->delete();
        Auth::logout();

        return [
            'message' => 'Logged out',
        ];
    }
}
