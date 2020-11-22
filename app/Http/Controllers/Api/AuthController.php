<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiLoginRequest;
use App\Http\Resources\AuthResource;
use App\Services\Users\UserService as Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(Service $service)
    {
        parent::__construct($service);
    }

    /**
     * @param ApiLoginRequest $request
     * @return AuthResource|JsonResponse
     */
    public function login(ApiLoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json([
                'message' => __('auth.failed'),
                'errors'  => 'Unauthorised'
            ], 401);
        }

        $user = $this->service->setToken(Auth::user());

        return new AuthResource($user);
    }
}
