<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller
{
    /**
     * Register middleware for the controller.
     */
    // public static function middleware(): array
    // {
    //     return [
    //         // Apply permissions using Spatie middleware
    //         new Middleware('permission:role-list', only: ['index', 'show']),
    //         new Middleware('permission:role-create', only: ['create', 'store']),
    //         new Middleware('permission:role-edit', only: ['edit', 'update']),
    //         new Middleware('permission:role-delete', only: ['destroy']),
    //     ];
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $data = Role::orderBy('id', 'DESC')->paginate(5);
        return view('app.roles.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permission = Permission::all();
        return view('app.roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
        ]);

        $permissionsID = array_map('intval', $request->input('permission'));

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($permissionsID);

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $role = Role::findOrFail($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('app.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $role = Role::findOrFail($id);
        $permission = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('app.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'permission' => 'required|array',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();

        $permissionsID = array_map('intval', $request->input('permission'));

        $role->syncPermissions($permissionsID);

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        Role::findOrFail($id)->delete();
        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
