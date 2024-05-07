<?php

namespace App\services;


use App\Common\AuditType;
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

            $user = User::where('email',$credentials['email'])->first();

            $service = new AuditTrailService();
            $service->logAuditTrail($user->id, AuditType::LOG_IN);

            return Auth::user();
        }catch (AuthenticationException $exception){
            $service = new AuditTrailService();
            $service->logAuditTrail(AuditType::ERROR, AuditType::LOG_IN);

            throw new $exception;
        }


    }
}
