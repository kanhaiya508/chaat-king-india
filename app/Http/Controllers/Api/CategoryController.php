<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Concerns\HasApiBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use HasApiBranch;

    /**
     * Display a listing of categories
     */
    public function index()
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        $query = Category::with(['branch', 'user', 'items']);
        $query = $this->applyBranchFilter($query);
        
        $categories = $query->get();
        
        return $this->successResponse($categories, 'Categories retrieved successfully');
    }

    /**
     * Display the specified category
     */
    public function show($id)
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        $query = Category::with(['branch', 'user', 'items'])->where('id', $id);
        $query = $this->applyBranchFilter($query);
        
        $category = $query->first();
        
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found or not accessible'
            ], 404);
        }

        return $this->successResponse($category, 'Category retrieved successfully');
    }

    /**
     * Get items by category
     */
    public function getItems($categoryId)
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        $query = Category::with(['branch', 'user', 'items.variants', 'items.addons'])
            ->where('id', $categoryId);
        $query = $this->applyBranchFilter($query);
        
        $category = $query->first();
        
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found or not accessible'
            ], 404);
        }

        return $this->successResponse($category->items, 'Items retrieved by category successfully');
    }
}


