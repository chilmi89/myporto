@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Role Redirect Management</h2>

    <!-- Button trigger Create Modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
        Tambah Redirect
    </button>

    <!-- Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Role</th>
                <th>Route Tujuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($redirects as $redirect)
            <tr>
                <td>{{ $redirect->role_name }}</td>
                <td>{{ $redirect->route_name }}</td>
                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $redirect->id }}">
                        Edit
                    </button>

                    <!-- Delete -->
                    <form action="{{ route('superadmin.role-redirects.destroy', $redirect) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $redirect->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('superadmin.role-redirects.update', $redirect) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Redirect</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Role Name</label>
                                    <input type="text" name="role_name" class="form-control" value="{{ $redirect->role_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Route Name</label>
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('superadmin.role-redirects.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Redirect</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Role Name</label>
                        <select name="role_name" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ ($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Route Name</label>
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
@endsection
