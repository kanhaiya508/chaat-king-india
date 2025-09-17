<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetCurrentBranch
{
    public function handle(Request $request, Closure $next)
    {
        // Already selected?
        if (session()->has('branch_id')) {
            return $next($request);
        }

        $user = $request->user();
        if (!$user) return $next($request);

        $branchIds = $user->branches()->pluck('branches.id')->all();

        if (count($branchIds) === 1) {
            session(['branch_id' => $branchIds[0]]);
            return $next($request);
        }

        // Multiple branches: ask to choose
        if (empty($branchIds)) {
            // Optional: block or let pass (no branch)
            return $next($request);
        }

        return redirect()->route('branches.choose');
    }
}
