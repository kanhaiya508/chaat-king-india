<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class WaiterAuthController extends Controller
{
    /**
     * Waiter login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if user exists and has waiter app access
        $user = User::where('email', $request->email)
            ->where('waiter_app_access', true)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials or no waiter access'
            ], 401);
        }

        // Get user's branches
        $branches = $user->branches;

        // Create token with error handling
        try {
            $token = $user->createToken('waiter-token')->plainTextToken;
            
            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create authentication token'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token creation failed: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'branches' => $branches,
                'token' => $token,
                'needs_branch_selection' => $branches->count() > 1
            ]
        ]);
    }

    /**
     * Select branch for waiter
     */
    public function selectBranch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch_id' => 'required|integer|exists:branches,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        
        // Check if user has waiter app access
        if (!$user->waiter_app_access) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Waiter app access required.'
            ], 403);
        }
        
        $branch = Branch::find($request->branch_id);

        // Check if user has access to this branch
        if (!$user->branches->contains($branch)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this branch'
            ], 403);
        }

        // Store selected branch in session or token
        $user->current_branch_id = $request->branch_id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Branch selected successfully',
            'data' => [
                'selected_branch' => $branch,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]
        ]);
    }

    /**
     * Get current waiter info
     */
    public function me()
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'current_branch' => $user->branches->where('id', $user->current_branch_id)->first(),
                'branches' => $user->branches
            ]
        ]);
    }

    /**
     * Get complete profile information
     */
    public function profile()
    {
        $user = Auth::user();
        
        // Check if user has waiter app access
        if (!$user->waiter_app_access) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Waiter app access required.'
            ], 403);
        }

        // Get current branch details
        $currentBranch = null;
        if ($user->current_branch_id) {
            $currentBranch = $user->branches->where('id', $user->current_branch_id)->first();
        }

        // Get all accessible branches with detailed information
        $branches = $user->branches->map(function ($branch) use ($user) {
            return [
                'id' => $branch->id,
                'name' => $branch->name,
                'address' => $branch->address ?? '',
                'phone' => $branch->phone ?? '',
                'email' => $branch->email ?? '',
                'is_current' => $branch->id == $user->current_branch_id,
                'created_at' => $branch->created_at,
                'updated_at' => $branch->updated_at,
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Profile retrieved successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'waiter_app_access' => $user->waiter_app_access,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ],
                'current_branch' => $currentBranch ? [
                    'id' => $currentBranch->id,
                    'name' => $currentBranch->name,
                    'address' => $currentBranch->address ?? '',
                    'phone' => $currentBranch->phone ?? '',
                    'email' => $currentBranch->email ?? '',
                    'created_at' => $currentBranch->created_at,
                    'updated_at' => $currentBranch->updated_at,
                ] : null,
                'branches' => $branches,
                'total_branches' => $branches->count(),
                'has_multiple_branches' => $branches->count() > 1,
                'branch_selection_required' => $branches->count() > 1 && !$user->current_branch_id,
            ]
        ]);
    }

    /**
     * Update profile information
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        
        // Check if user has waiter app access
        if (!$user->waiter_app_access) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Waiter app access required.'
            ], 403);
        }

        // Update user information
        $updateData = [];
        if ($request->has('name')) {
            $updateData['name'] = $request->name;
        }
        if ($request->has('email')) {
            $updateData['email'] = $request->email;
        }

        if (empty($updateData)) {
            return response()->json([
                'success' => false,
                'message' => 'No valid fields provided for update'
            ], 400);
        }

        try {
            $user->update($updateData);
            
            // Refresh user data
            $user->refresh();
            
            // Get current branch details
            $currentBranch = null;
            if ($user->current_branch_id) {
                $currentBranch = $user->branches->where('id', $user->current_branch_id)->first();
            }

            // Get all accessible branches with detailed information
            $branches = $user->branches->map(function ($branch) use ($user) {
                return [
                    'id' => $branch->id,
                    'name' => $branch->name,
                    'address' => $branch->address ?? '',
                    'phone' => $branch->phone ?? '',
                    'email' => $branch->email ?? '',
                    'is_current' => $branch->id == $user->current_branch_id,
                    'created_at' => $branch->created_at,
                    'updated_at' => $branch->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'waiter_app_access' => $user->waiter_app_access,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                    ],
                    'current_branch' => $currentBranch ? [
                        'id' => $currentBranch->id,
                        'name' => $currentBranch->name,
                        'address' => $currentBranch->address ?? '',
                        'phone' => $currentBranch->phone ?? '',
                        'email' => $currentBranch->email ?? '',
                        'created_at' => $currentBranch->created_at,
                        'updated_at' => $currentBranch->updated_at,
                    ] : null,
                    'branches' => $branches,
                    'total_branches' => $branches->count(),
                    'has_multiple_branches' => $branches->count() > 1,
                    'branch_selection_required' => $branches->count() > 1 && !$user->current_branch_id,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }
}
