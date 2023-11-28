<?php

namespace App\services;


use App\Exceptions\AuthenticationException;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * @throws AuthenticationException
     */
    public function login(array $credentials): Authenticatable
    {
        try {
            if (!Auth::attempt($credentials)) {

                throw new AuthenticationException("The provided login credentials do not match our records.");
            }

            return Auth::user();
        }catch (AuthenticationException $exception){
            throw new $exception;
        }


    }
}
