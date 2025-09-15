@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Role & Permission Route</h2>

    {{-- Success message --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ===== ROLE REDIRECT ===== --}}
    <div class="mb-5">
        <h4>Role Redirect</h4>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createRoleRedirectModal">
            Tambah Role Redirect
        </button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Route Tujuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roleRedirects as $redirect)
                <tr>
                    <td>{{ $redirect->role_name }}</td>
                    <td>{{ $redirect->route_name }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRoleRedirectModal{{ $redirect->id }}">Edit</button>

                        <form action="{{ route('superadmin.role-redirects.destroy', $redirect->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editRoleRedirectModal{{ $redirect->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('superadmin.role-redirects.update', $redirect->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Role Redirect</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Role</label>
                                        <input type="text" class="form-control" value="{{ $redirect->role_name }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label>Route Tujuan</label>
                                        <input type="text" name="route_name" class="form-control" value="{{ $redirect->route_name }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-success">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Create Role Redirect Modal --}}
    <div class="modal fade" id="createRoleRedirectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('superadmin.role-redirects.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Role Redirect</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role_name" class="form-control" required>
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Route Tujuan</label>
                            <input type="text" name="route_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== PERMISSION ROUTE ===== --}}
    <div class="mt-5">
        <h4>Permission Route</h4>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPermissionRouteModal">
            Tambah Permission Route
        </button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Permission</th>
                    <th>Route Tujuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissionRoutes as $p)
                <tr>
                    <td>{{ $p->permission_name }}</td>
                    <td>{{ $p->route_name }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPermissionRouteModal{{ $p->id }}">Edit</button>

                        <form action="{{ route('superadmin.permission-routes.destroy', $p->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editPermissionRouteModal{{ $p->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('superadmin.permission-routes.update', $p->id) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Permission Route</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Permission</label>
                                        <input type="text" class="form-control" value="{{ $p->permission_name }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label>Route Tujuan</label>
                                        <select name="route_name" class="form-control" required>
                                            <option value="">-- Pilih Route --</option>
                                            @foreach($roleRedirects as $redirect)
                                            <option value="{{ $redirect->route_name }}" {{ (isset($permissionRoute) && $permissionRoute->route_name == $redirect->route_name) ? 'selected' : '' }}>
                                                {{ $redirect->route_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-success">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Create Permission Route Modal --}}
    <div class="modal fade" id="createPermissionRouteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('superadmin.permission-routes.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Permission Route</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Permission</label>
                            <select name="permission_name" class="form-control" required>
                                <option value="">Pilih Permission</option>
                                @foreach($permissions as $perm)
                                <option value="{{ $perm->name }}">{{ $perm->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-3">
                            <label>Route Tujuan</label>
                            <select name="route_name" class="form-control" required>
                                <option value="">-- Pilih Route --</option>
                                @foreach($roleRedirects as $redirect)
                                <option value="{{ $redirect->route_name }}" {{ (isset($permissionRoute) && $permissionRoute->route_name == $redirect->route_name) ? 'selected' : '' }}>
                                    {{ $redirect->route_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
