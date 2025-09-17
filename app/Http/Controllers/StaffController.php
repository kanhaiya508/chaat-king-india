<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    /**
     * Display a listing of the staff.
     */
    public function index()
    {
        $staff = Staff::latest()->paginate(10);
        return view('app.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create()
    {
        return view('app.staff.create');
    }

    /**
     * Store a newly created staff member in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'father_name'     => 'nullable|string|max:255',
            'phone'           => 'required|string|max:15|unique:staff,phone',
            'address'         => 'nullable|string|max:500',
            'aadhaar_number'  => 'required|string|size:12|unique:staff,aadhaar_number',
            'designation'     => 'nullable|string|max:100',
        ]);

        Staff::create($validated);

        return redirect()->route('staff.index')
            ->with('success', 'Staff created successfully.');
    }

    /**
     * Display the specified staff member.
     */
    public function show(Staff $staff)
    {
        return view('app.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit(Staff $staff)
    {
        return view('app.staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff member in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'father_name'     => 'nullable|string|max:255',
            'phone'           => [
                'required',
                'string',
                'max:15',
                Rule::unique('staff', 'phone')->ignore($staff->id),
            ],
            'address'         => 'nullable|string|max:500',
            'aadhaar_number'  => [
                'required',
                'string',
                'size:12',
                Rule::unique('staff', 'aadhaar_number')->ignore($staff->id),
            ],
            'designation'     => 'nullable|string|max:100',
        ]);

        $staff->update($validated);

        return redirect()->route('staff.index')
            ->with('success', 'Staff updated successfully.');
    }

    /**
     * Remove the specified staff member from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Staff deleted successfully.');
    }
}
