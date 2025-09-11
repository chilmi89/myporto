@extends('layouts.master')


@section('content')

<div class="container-fluid">

    <div class="container">
        <h3>Manajemen Role & Permission</h3>

        <div class="row">
            <!-- Form tambah role -->
            <div class="col-md-6">
                <h5>Buat Role Baru</h5>
                <form action="{{ route('role.create') }}" method="POST">
                    @csrf
                    <input type="text" name="name" class="form-control mb-2" placeholder="Nama role" required>
                    <button class="btn btn-primary">Tambah Role</button>
                </form>
            </div>

            <!-- Form tambah permission -->
            <div class="col-md-6">
                <h5>Buat Permission Baru</h5>
                <form action="{{ route('permission.create') }}" method="POST">
                    @csrf
                    <input type="text" name="name" class="form-control mb-2" placeholder="Nama permission" required>
                    <button class="btn btn-success">Tambah Permission</button>
                </form>
            </div>
        </div>

        <hr>

        <h5>Daftar Role</h5>
        <ul>
            @foreach($roles as $role)
            <li>
                <strong>{{ $role->name }}</strong>
                <br> Permission: {{ $role->permissions->pluck('name')->join(', ') ?: 'Belum ada' }}

                <!-- Form assign permission -->
                <form action="{{ route('role.assign.permission') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role->name }}">
                    <select name="permission" class="form-select d-inline w-auto">
                        @foreach($permissions as $perm)
                        <option value="{{ $perm->name }}">{{ $perm->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary">Tambah</button>
                </form>

                <!-- Form revoke permission -->
                @if($role->permissions->count())
                <form action="{{ route('role.revoke.permission') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role->name }}">
                    <select name="permission" class="form-select d-inline w-auto">
                        @foreach($role->permissions as $perm)
                        <option value="{{ $perm->name }}">{{ $perm->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
                @endif
            </li>
            @endforeach
        </ul>
    </div>

</div>

@endsection
