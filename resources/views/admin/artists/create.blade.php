@extends('layouts.admin')

@section('title', 'Zentify | Tambah Artis')

<link rel="stylesheet" href="{{ asset('admin/css/artists/artist-create.css')}}">

@section('content')
<div class="container">
    <h2>Tambah Artis Baru</h2>

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.artists.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="name">Nama Artis:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
        </div>

        <div class="mb-4">
            <label for="bio">Bio Artis:</label>
            <textarea name="bio" id="bio" rows="5">{{ old('bio') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="photo">Foto Artis:</label>
            <input type="file" name="photo" id="photo">
        </div>

        <div class="mb-4">
            <button type="submit">Simpan</button>
        </div>
    </form>
</div>
@endsection
