<?php

declare(strict_types=1);

namespace App\Http\Middleware;


use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->headers->get('token');
        if (!is_null($token)) {
            $user = User::where('api_token', $token)->first();

            if (!$user) {
                $this->sendError();
            }

            Auth::login($user);
            return $next($request);
        }

        return $this->sendError();
    }

    private function sendError(): JsonResponse
    {
        return response()->json([
            'message' => __('auth.invalid_token'),
            'errors'  => 'Unauthorised'
        ], 401);
    }
}
