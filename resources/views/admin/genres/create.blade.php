@extends('layouts.admin')

@section('title', 'Zentify | Tambah Genre')

<link rel="stylesheet" href="{{ asset('admin/css/genres/genre-create.css')}}">
@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Genre Baru</h1>

    {{-- Menampilkan pesan error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.genres.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Genre</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
        </div>
        <button type="submit" class="btn">Tambah Genre</button>
    </form>
</div>
@endsection
