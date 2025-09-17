<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Branch;  // import branch model

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request): View
    {
        $data = User::latest()->paginate(5);
        return view('app.users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();
        $branches = Branch::pluck('name', 'id')->all();
        return view('app.users.create', compact('roles', 'branches'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'branches' => 'required|array'
        ]);

        $input = $request->only(['name', 'email', 'password', 'roles', 'waiter_app_access']);
        $input['password'] = Hash::make($input['password']);
        
        // Handle checkbox - if not checked, set to false
        $input['waiter_app_access'] = $request->has('waiter_app_access') ? true : false;

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        $user->branches()->sync($request->input('branches'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        return view('app.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $branches = Branch::pluck('name', 'id')->all();
        $userBranches = $user->branches->pluck('id')->toArray();


        return view('app.users.edit', compact('user', 'roles', 'userRole', 'branches', 'userBranches'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|same:confirm-password',
            'roles' => 'required',
            'branches' => 'required|array'
        ]);

        $input = $request->only(['name', 'email', 'password', 'roles', 'waiter_app_access']);
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }
        
        // Handle checkbox - if not checked, set to false
        $input['waiter_app_access'] = $request->has('waiter_app_access') ? true : false;

        $user->update($input);
        $user->syncRoles($request->input('roles'));
        $user->branches()->sync($request->input('branches'));
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
