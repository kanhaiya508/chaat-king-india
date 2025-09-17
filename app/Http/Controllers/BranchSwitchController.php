<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchSwitchController extends Controller
{
    // Branch switch
    public function switch(Branch $branch)
    {
        if (auth()->user()->branches->contains($branch)) {
            $alreadySelected = session()->has('branch_id'); // check if branch already selected

            session(['branch_id' => $branch->id]);

            if ($alreadySelected) {
                return back(); // if already selected before
            }
            return redirect()->route('dashboard'); // first time selection
        }
        return back()->with('error', 'You are not authorized for this branch.');
    }
    // Branch choose page
    public function choose()
    {
        $branches = auth()->user()->branches;
        $currentBranchId = session('branch_id');
        return view('app.auth.branche', compact('branches', 'currentBranchId'));
    }
}
