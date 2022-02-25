<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

use Illuminate\Support\Str;

class ForgotController extends Controller
{
    public function forgot(ForgotRequest $request)
    {
        $email = $request->input('email');

        if (User::where('email', $email)->doesntExist()) {
            return response([
                'message' => 'User doesn\'t exists!',
            ], 404);
        }

       $token = Str::random(20);

        try {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
            ]);

            return response([
                'message' => 'Reset token',
                'token' => $token,
            ]);

        } catch (\Exception$exception) {
            return response([
                'message' => $exception->getMessage(),
            ]);
        }

    }
    public function reset(ResetRequest $request)
    {
        $token = $request->input('token');

        if (!$passwordResets = DB::table('password_resets')->where('token', $token)->first()) {

            return response([
                'message' => 'Invalid token!',
            ], 400);
        }
        /** @var User $user */
        if (!$user = User::where('email', $passwordResets->email)->first()) {
            return response([
                'message' => 'User doesn\'t exist',
            ], 404);
        }
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return response([
            'message' => 'password update successfully',
        ], 200);

    }
}
