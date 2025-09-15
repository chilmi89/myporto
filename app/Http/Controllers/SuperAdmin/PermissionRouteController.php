<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\RoleRedirect;
use App\Models\PermissionRoute;

class PermissionRouteController extends Controller
{
    public function index()
    {
        $roleRedirects = RoleRedirect::latest()->get();
        $permissionRoutes = PermissionRoute::latest()->get();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('SuperAdmin.DashboardPermissionRoute', compact(
            'roleRedirects',
            'permissionRoutes',
            'roles',
            'permissions'
        ));
    }

    // ---------------- Role Redirect ----------------
    public function storeRoleRedirect(Request $request)
    {
        $request->validate([
            'role_name'  => 'required|string|exists:roles,name|unique:role_redirects,role_name',
            'route_name' => 'required|string|max:150',
        ]);

        RoleRedirect::create([
            'role_name'  => $request->role_name,
            'route_name' => $request->route_name,
        ]);

        return redirect()->back()->with('success', 'Role Redirect berhasil ditambahkan.');
    }



    public function updateRoleRedirect(Request $request, RoleRedirect $roleRedirect)
    {
        $request->validate([
            'route_name' => 'required|string|max:150',
        ]);

        $roleRedirect->update([
            'route_name' => $request->route_name,
        ]);

        return redirect()->back()->with('success', 'Role Redirect berhasil diperbarui.');
    }

    public function destroyRoleRedirect(RoleRedirect $roleRedirect)
    {
        $roleRedirect->delete();
        return redirect()->back()->with('success', 'Role Redirect berhasil dihapus.');
    }

    // ---------------- Permission Route ----------------
    public function storePermissionRoute(Request $request)
    {
        $request->validate([
            'permission_name' => 'required|string|exists:permissions,name|unique:permission_routes,permission_name',
            'route_name'      => 'required|string|max:150',
        ]);

        PermissionRoute::create([
            'permission_name' => $request->permission_name,
            'route_name'      => $request->route_name,
        ]);

        return redirect()->back()->with('success', 'Permission Route berhasil ditambahkan.');
    }

    public function updatePermissionRoute(Request $request, PermissionRoute $permissionRoute)
    {
        $request->validate([
            'route_name' => 'required|string|max:150',
        ]);

        $permissionRoute->update([
            'route_name' => $request->route_name,
        ]);

        return redirect()->back()->with('success', 'Permission Route berhasil diperbarui.');
    }

    public function destroyPermissionRoute(PermissionRoute $permissionRoute)
    {
        $permissionRoute->delete();
        return redirect()->back()->with('success', 'Permission Route berhasil dihapus.');
    }
}
