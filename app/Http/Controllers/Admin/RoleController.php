<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::withCount('users')->latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $availablePermissions = $this->getAvailablePermissions();
        return view('admin.roles.create', compact('availablePermissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $availablePermissions = $this->getAvailablePermissions();
        return view('admin.roles.edit', compact('role', 'availablePermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string'
        ]);

        $role->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        // Prevent deletion of the admin role
        if ($role->slug === 'admin') {
            return back()->with('error', 'The admin role cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    /**
     * Update the permissions for a role.
     */
    public function updatePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'string'
        ]);

        $role->update([
            'permissions' => $request->permissions ?? []
        ]);

        return back()->with('success', 'Role permissions updated successfully.');
    }

    /**
     * Get the list of available permissions.
     */
    private function getAvailablePermissions()
    {
        return [
            'view_dashboard' => 'View Dashboard',
            'manage_users' => 'Manage Users',
            'manage_roles' => 'Manage Roles',
            'manage_devices' => 'Manage Devices',
            'manage_categories' => 'Manage Categories',
            'manage_rentals' => 'Manage Rentals',
            'view_reports' => 'View Reports',
            'manage_settings' => 'Manage Settings'
        ];
    }
} 