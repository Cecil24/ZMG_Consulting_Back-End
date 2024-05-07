<?php

namespace App\Http\Controllers;

use App\Common\AuditType;
use App\Exceptions\AuthenticationException;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\services\AuditTrailService;
use App\services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @param AuthService $service
     * @return Response|void
     */
    public function login(LoginRequest $request, AuthService $service)
    {
        try {
            $service->login($request->only(['email','password']));
        }catch (AuthenticationException $exception){
            return $this->jsonUnAuthorized($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getLoggedUser(Request $request): Response
    {
        return $this->jsonResource(UserResource::make($request->user()));
    }

    /**
     * @return Response
     */
    public function logout(): Response
    {
        Auth::logout();
        $user = Auth::user();
        $service = new AuditTrailService();
        $service->logAuditTrail($user['id'], AuditType::LOG_OUT);
        return $this->jsonSuccess();
    }

}
