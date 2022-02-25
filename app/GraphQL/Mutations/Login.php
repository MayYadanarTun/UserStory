<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Login
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    // public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    // {
    //     $credentials = Arr::only($args, ['email', 'password']);

    //     if (Auth::once($credentials)) {
    //         $token = Str::random(60);

    //         $user = auth()->user();
    //         $user->api_token = $token;

    //         return $token;
    //     }

    //     return null;
    // }
    public function resolve($_, array $args)
    {
        try{
           
            if(Auth::attempt(['email' => $args['email'], 'password' => $args['password']])  ){
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
}
