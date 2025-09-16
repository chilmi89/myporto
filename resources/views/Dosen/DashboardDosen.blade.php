@extends("layouts.all")

@section("content")
<h1>ini adalah halaman dosen</h1>


@can('read')
    <btn>hallo</btn>
@endcan



@endsection
