<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WaiterAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure this is an API request
        if (!$request->expectsJson() && !$request->is('api/*')) {
            return $next($request);
        }

        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please login first.',
                'error_code' => 'UNAUTHENTICATED'
            ], 401);
        }

        $user = auth()->user();

        // Check if user has waiter app access
        if (!$user->waiter_app_access) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Waiter app access required.',
                'error_code' => 'NO_WAITER_ACCESS'
            ], 403);
        }

        // Check if user has selected a branch
        if (!$user->current_branch_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a branch first',
                'needs_branch_selection' => true,
                'error_code' => 'BRANCH_NOT_SELECTED'
            ], 403);
        }

        // Verify user has access to the selected branch
        if (!$user->branches->contains('id', $user->current_branch_id)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to the selected branch',
                'error_code' => 'BRANCH_ACCESS_DENIED'
            ], 403);
        }

        return $next($request);
    }
}
