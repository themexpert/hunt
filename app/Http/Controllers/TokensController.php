<?php

namespace App\Http\Controllers;

use App\User;

class TokensController extends Controller
{
    /**
     * Validate token.
     *
     * @param string $token
     * @return \Illuminate\Http\Response
     */
    public function token($token)
    {
        $user = User::whereToken($token)->first();

        if(is_null($user)) {
            return redirect()->to('/login')->with(['message' => 'Token does not exist']);
        }

        $user->is_active = 1;
        $user->token = '';

        $user->save();

        return redirect()->to('/login')->with(['message' => 'Enter your email and password']);
    }
}
