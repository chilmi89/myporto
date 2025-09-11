<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('SuperAdmin.DashboardAdmin', compact('roles', 'permissions'));
    }
    
    public function createRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create(['name' => $request->name]);
        return back()->with('success', 'Role berhasil dibuat!');
    }

    public function createPermission(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions,name']);
        Permission::create(['name' => $request->name]);
        return back()->with('success', 'Permission berhasil dibuat!');
    }

    public function givePermissionToRole(Request $request)
    {
        $role = Role::findByName($request->role);
        $role->givePermissionTo($request->permission);
        return back()->with('success', 'Permission ditambahkan ke role!');
    }

    public function revokePermissionFromRole(Request $request)
    {
        $role = Role::findByName($request->role);
        $role->revokePermissionTo($request->permission);
        return back()->with('success', 'Permission dicabut dari role!');
    }
}
