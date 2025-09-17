<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tablecategory;
use App\Models\Concerns\HasApiBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TablecategoryController extends Controller
{
    use HasApiBranch;

    /**
     * Display a listing of table categories
     */
    public function index()
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        $query = Tablecategory::with(['branch', 'tables']);
        $query = $this->applyBranchFilter($query);
        
        $tablecategories = $query->get();
        
        return $this->successResponse($tablecategories, 'Table categories retrieved successfully');
    }

    /**
     * Display the specified table category
     */
    public function show($id)
    {
        if (!$this->hasSelectedBranch()) {
            return $this->branchSelectionError();
        }
        
        $query = Tablecategory::with(['branch', 'tables'])->where('id', $id);
        $query = $this->applyBranchFilter($query);
        
        $tablecategory = $query->first();
        
        if (!$tablecategory) {
            return response()->json([
                'success' => false,
                'message' => 'Table category not found or not accessible'
            ], 404);
        }

        return $this->successResponse($tablecategory, 'Table category retrieved successfully');
    }
}
