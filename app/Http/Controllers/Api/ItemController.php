<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Concerns\HasApiBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    use HasApiBranch;

    /**
     * Display a listing of items
     */
    public function index()
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        $query = Item::with(['category', 'variants', 'addons']);
        $query = $this->applyBranchFilter($query);
        
        $items = $query->get();
        
        return $this->successResponse($items, 'Items retrieved successfully');
    }

    /**
     * Display the specified item
     */
    public function show($id)
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        $query = Item::with(['category', 'variants', 'addons'])->where('id', $id);
        $query = $this->applyBranchFilter($query);
        
        $item = $query->first();
        
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found or not accessible'
            ], 404);
        }

        return $this->successResponse($item, 'Item retrieved successfully');
    }

    /**
     * Get items by category
     */
    public function getByCategory($categoryId)
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        $query = Item::with(['branch', 'user', 'category', 'variants', 'addons'])
            ->where('category_id', $categoryId);
        $query = $this->applyBranchFilter($query);
        
        $items = $query->get();
        
        return $this->successResponse($items, 'Items retrieved by category successfully');
    }

    /**
     * Get available items only
     */
    public function getAvailable()
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        $query = Item::with(['branch', 'user', 'category', 'variants', 'addons'])
            ->where('is_available', true);
        $query = $this->applyBranchFilter($query);
        
        $items = $query->get();
        
        return $this->successResponse($items, 'Available items retrieved successfully');
    }

    /**
     * Get items by type
     */
    public function getByType($type)
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        $allowedTypes = Item::allowedTypes();
        if (!in_array($type, $allowedTypes)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid item type. Allowed types: ' . implode(', ', $allowedTypes)
            ], 400);
        }
        
        $query = Item::with(['branch', 'user', 'category', 'variants', 'addons'])
            ->where('type', $type);
        $query = $this->applyBranchFilter($query);
        
        $items = $query->get();
        
        return $this->successResponse($items, 'Items retrieved by type successfully');
    }
}
