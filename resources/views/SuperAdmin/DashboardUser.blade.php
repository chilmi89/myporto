@extends('layouts.master')
@section('content')

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">User Management</h1>
<p class="mb-4">Kelola daftar user aplikasi di bawah ini.</p>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- DataTales Example -->
<div class="card shadow mb-4">


    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
        <!-- Button Tambah User di kanan -->
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus"></i> Tambah User
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-fixed align-middle text-center" id="dataTable" width="100%" cellspacing="0" style="table-layout: fixed;">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">Name</th>
                        <th style="width: 25%;">Email</th>
                        <th style="width: 20%;">Role</th>
                        <th style="width: 30%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ $user->name }}</td>
                        <td class="text-truncate" style="max-width: 250px;">{{ $user->email }}</td>
                        <td>
                            <div class="d-flex flex-wrap justify-content-center py-2" style="margin: 0 auto;">
                                @forelse($user->getRoleNames() as $role)
                                @php
                                switch ($role) {
                                case 'superadmin': $color = 'bg-danger text-white'; break;
                                case 'admin': $color = 'bg-primary text-white'; break;
                                case 'guru': $color = 'bg-success text-white'; break;
                                case 'siswa': $color = 'bg-warning text-dark'; break;
                                default: $color = 'bg-secondary text-white';
                                }
                                @endphp
                                <span class="badge {{ $color }}">{{ ucfirst($role) }}</span>
                                @empty
                                <span class="badge bg-light text-dark">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <!-- Button Edit -->
                                <button type="button" class="btn btn-outline-warning me-2" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" data-bs-toggle="tooltip" title="Edit user & roles">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </button>

                                <!-- Button View Permissions -->
                                <button type="button" class="btn btn-outline-info me-2 btn-view-permissions" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-bs-toggle="modal" data-bs-target="#viewPermissionModal" data-bs-toggle="tooltip" title="Lihat semua permissions user">
                                    <i class="fas fa-eye me-1"></i> Permissions
                                </button>

                                <!-- Button Delete -->
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}" data-bs-toggle="tooltip" title="Hapus user">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </button>
                            </div>
                        </td>

                    </tr>

                    {{-- Modal Edit, Delete, View Permission tetap sama --}}
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg"> {{-- modal-lg biar agak lebar --}}
                            <div class="modal-content">
                                <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header bg-warning">
                                        <h5 class="modal-title">Edit Role & Permission - {{ $user->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                                        </div>

                                        <!-- Checkbox Roles -->
                                        <div class="mb-3">
                                            <label>Pilih Role</label>
                                            <div class="row">
                                                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" {{ $user->roles->pluck('name')->contains($role->name) ? 'checked' : '' }}>
                                                        <label class="form-check-label">
                                                            {{ ($role->name) }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Checkbox Permissions -->
                                        <div class="mb-3">
                                            <label>Permission Langsung</label>
                                            <div class="row">
                                                @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ $user->permissions->pluck('name')->contains($permission->name) ? 'checked' : '' }}>
                                                        <label class="form-check-label">
                                                            {{ ucfirst($permission->name) }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <small class="text-muted">
                                                Centang permission di sini berlaku langsung ke user, tidak tergantung role.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header bg-danger">
                                        <h5 class="modal-title text-white">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah kamu yakin ingin menghapus user <strong>{{ $user->name }}</strong> ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- modal view permission --}}

                    <!-- Modal View Permissions Per Role -->
                    <div class="modal fade" id="viewPermissionModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" style="max-width: 600px; max-height: 70vh;">
                            <!-- max-height 70% dari viewport, modal scrollable -->
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title">
                                        <i class="fas fa-user-lock"></i> Permissions - <span id="modalUserName"></span>
                                        <small class="badge bg-warning text-dark ms-2" id="modalUpdatedAt">Update Terbaru</small>
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body" id="modalPermissionBody" style="max-height: 60vh; overflow-y: auto;">
                                    <p class="text-muted">Memuat data terbaru...</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i> Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- modal tambah --}}
                    <!-- Modal Tambah User -->
                    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <form action="{{ route('superadmin.users.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-header bg-success">
                                        <h5 class="modal-title">Tambah User Baru</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>

                                        <!-- Checkbox Roles -->
                                        <div class="mb-3">
                                            <label>Pilih Role</label>
                                            <div class="row">
                                                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}">
                                                        <label class="form-check-label">{{ ($role->name) }}</label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".btn-view-permissions").forEach(function(btn) {
            btn.addEventListener("click", function() {
                const userId = this.dataset.userId;
                const userName = this.dataset.userName;

                document.getElementById("modalUserName").textContent = userName;
                document.getElementById("modalPermissionBody").innerHTML = "<p class='text-muted'>Memuat data terbaru...</p>";

                fetch(`/superadmin/users/${userId}/permissions`)
                    .then(res => res.json())
                    .then(data => {
                        let html = '';

                        if (data.permissions.length > 0) {
                            html += `<ul class="list-group list-group-flush">`;
                            data.permissions.forEach(perm => {
                                html += `<li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-2"></i> ${perm}
                                    </li>`;
                            });
                            html += `</ul>`;
                        } else {
                            html = "<p class='text-muted'>User ini belum memiliki permission.</p>";
                        }

                        document.getElementById("modalUpdatedAt").textContent = `Update Terbaru: ${data.updated_at}`;
                        document.getElementById("modalPermissionBody").innerHTML = html;
                    })
                    .catch(err => {
                        document.getElementById("modalPermissionBody").innerHTML = "<p class='text-danger'>Gagal memuat data terbaru.</p>";
                    });
            });
        });
    });

</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });

</script>




@endsection
