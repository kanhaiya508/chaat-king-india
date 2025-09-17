<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Auth;

trait HasApiBranch
{
    /**
     * Get current branch ID for API requests
     */
    protected function getCurrentBranchId()
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }
        
        return $user->current_branch_id;
    }

    /**
     * Check if user is authenticated
     */
    protected function isAuthenticated()
    {
        return Auth::check();
    }

    /**
     * Get authentication error response
     */
    protected function authenticationError()
    {
        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated. Please login first.'
        ], 401);
    }

    /**
     * Check if user has selected a branch
     */
    protected function hasSelectedBranch()
    {
        return !is_null($this->getCurrentBranchId());
    }

    /**
     * Get branch selection error response
     */
    protected function branchSelectionError()
    {
        return response()->json([
            'success' => false,
            'message' => 'Please select a branch first',
            'needs_branch_selection' => true
        ], 403);
    }

    /**
     * Apply branch filter to query
     */
    protected function applyBranchFilter($query, $branchId = null)
    {
        $branchId = $branchId ?? $this->getCurrentBranchId();
        
        if (!$branchId) {
            return null; // Will trigger branch selection error
        }
        
        return $query->where('branch_id', $branchId);
    }

    /**
     * Get success response with branch info
     */
    protected function successResponse($data, $message, $additionalData = [])
    {
        return response()->json(array_merge([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'branch_id' => $this->getCurrentBranchId()
        ], $additionalData));
    }
}
