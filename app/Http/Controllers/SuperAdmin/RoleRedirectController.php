<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\RoleRedirect;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleRedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $redirects = RoleRedirect::latest()->get();
        $roles = Role::all(); // ambil semua role
        return view('SuperAdmin.DashboardRoleRedirect', compact('redirects', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_name'  => 'required|string|max:100|unique:role_redirects,role_name',
            'route_name' => 'required|string|max:150'
        ]);

        RoleRedirect::create($validated);

        return redirect()
            ->route('superadmin.role-redirects.index')
            ->with('success', 'Role Redirect berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleRedirect $roleRedirect)
    {
        $validated = $request->validate([
            'role_name'  => 'required|string|max:100|unique:role_redirects,role_name,' . $roleRedirect->id,
            'route_name' => 'required|string|max:150'
        ]);

        $roleRedirect->update($validated);

        return redirect()
            ->route('superadmin.role-redirects.index')
            ->with('success', 'Role Redirect berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleRedirect $roleRedirect)
    {
        $roleRedirect->delete();

        return redirect()
            ->route('superadmin.role-redirects.index')
            ->with('success', 'Role Redirect berhasil dihapus.');
    }
}
