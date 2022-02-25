<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;

session_start();
class Logout
{

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    
    public function __invoke($_, array $args)
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json(['success' =>'logout_success'],200); 
        }else{
            return response()->json(['error' =>'api.something_went_wrong'], 500);
        }
    }
}
