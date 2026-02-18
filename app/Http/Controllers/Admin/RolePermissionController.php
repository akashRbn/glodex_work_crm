<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function roleList()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        $users = User::where('user_type', 1)->orderBy('name')->get();
        return view('admin.role-permission.role-list', compact('roles', 'users'));
    }

    // Function to assign role to user
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'role_name' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);

        // Remove previous roles (optional)
        // $user->syncRoles($request->role_name);

        // Or just assign additional role
        $user->assignRole($request->role_name);

        Alert::success('Success', 'Role assigned to user successfully!');
        return redirect()->back();
    }

    public function permissionList()
    {
        $permissions = Permission::orderBy('id', 'desc')->get();
        return view('admin.role-permission.permission-list', compact('permissions'));
    }

    // Function to save permission
    public function savePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        Alert::success('Success', 'Permission created successfully!');
        return redirect()->back();
    }

    // Function to save role
    public function saveRole(Request $request)
    {
        $request->validate([
            'role_name'   => 'required|unique:roles,name',
            'permissions' => 'required'
        ]);

        // Create role
        $role = Role::create([
            'name' => $request->role_name
        ]);

        // Create permissions if not exist & assign to role
        foreach ($request->permissions as $permissionName) {
            $permission = Permission::firstOrCreate([
                'name' => $permissionName
            ]);

            $role->givePermissionTo($permission);
        }

        Alert::success('Success', 'Role & permissions created successfully!');
        return redirect()->back();
    }

    // Function to update role
    public function updateRole(Request $request)
    {
        $request->validate([
            'role_id'   => 'required|exists:roles,id',
            'role_name' => 'required|unique:roles,name,' . $request->role_id,
            'permissions' => 'required|array'
        ]);

        $role = Role::findOrFail($request->role_id);

        // Update role name
        $role->name = $request->role_name;
        $role->save();

        // Update permissions
        $permissions = [];
        foreach ($request->permissions as $permName) {
            $permission = Permission::firstOrCreate(['name' => $permName]);
            $permissions[] = $permission;
        }

        $role->syncPermissions($permissions);

        Alert::success('Success', 'Role updated successfully!');
        return redirect()->back();
    }

}
