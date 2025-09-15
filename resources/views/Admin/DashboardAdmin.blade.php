@extends('layouts.all')

@section('content')

<!-- Page Heading -->
@can('roles')

@endcan
<h1 class="h3 mb-2 text-red-800">Ini adalah dashbaord admin</h1>
<p class="mb-4">Kelola daftar user aplikasi di bawah ini.</p>

@endsection
