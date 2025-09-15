<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil user dengan relasi roles & permissions langsung
        $users = User::with(['roles', 'permissions'])->get();

        return view('SuperAdmin.DashboardUser', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'roles'     => 'array|nullable'
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Jika ada role yang dipilih
        if ($request->filled('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'roles'       => 'array|nullable',
            'permissions' => 'array|nullable',
        ]);

        $user = User::findOrFail($id);

        // Sinkronisasi roles
        $user->syncRoles($request->roles ?? []);

        // Sinkronisasi direct permissions
        $user->syncPermissions($request->permissions ?? []);

        // Pastikan relasi di-refresh
        $user->load('roles', 'permissions');

        return redirect()->route('superadmin.users.index')
            ->with('success', 'Role & Permission user berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil dihapus');
    }

    public function getPermissions($id)
    {
        $user = User::with('roles.permissions', 'permissions')->findOrFail($id);

        // Gabungkan semua permissions (role + direct) dan ambil unik
        $allPermissions = $user->roles
            ->flatMap(fn($role) => $role->permissions->pluck('name'))
            ->merge($user->permissions->pluck('name'))
            ->unique();

        return response()->json([
            'permissions' => $allPermissions->values(),
            'updated_at'  => $user->updated_at->format('d M Y H:i') // label update terbaru
        ]);
    }
}
