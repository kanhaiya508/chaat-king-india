<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the branches.
     */
    public function index()
    {
        $branches = Branch::latest()->paginate(10);

        return view('app.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new branch.
     */
    public function create()
    {
        return view('app.branches.create');
    }

    /**
     * Store a newly created branch in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'gst_number'     => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:500',
            'is_active'      => 'boolean',
        ]);

        Branch::create($validated);

        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully.');
    }

    /**
     * Display the specified branch.
     */
    public function show(Branch $branch)
    {
        return view('app.branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified branch.
     */
    public function edit(Branch $branch)
    {
        return view('app.branches.edit', compact('branch'));
    }

    /**
     * Update the specified branch in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'gst_number'     => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:500',
            'is_active'      => 'boolean',
        ]);

        $branch->update($validated);

        return redirect()->route('branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Branch deleted successfully.');
    }
}
