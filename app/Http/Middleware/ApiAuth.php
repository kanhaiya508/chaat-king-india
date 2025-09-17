<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the token from the Authorization header
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please provide a valid token.',
                'error_code' => 'NO_TOKEN'
            ], 401);
        }

        // Find the token in the database
        $accessToken = PersonalAccessToken::findToken($token);
        
        if (!$accessToken) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid token.',
                'error_code' => 'INVALID_TOKEN'
            ], 401);
        }

        // Check if token is expired
        if ($accessToken->expires_at && $accessToken->expires_at->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Token has expired.',
                'error_code' => 'TOKEN_EXPIRED'
            ], 401);
        }

        // Set the authenticated user
        $user = $accessToken->tokenable;
        auth()->setUser($user);

        // Update last used timestamp
        $accessToken->update(['last_used_at' => now()]);

        return $next($request);
    }
}
