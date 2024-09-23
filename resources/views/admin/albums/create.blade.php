@extends('layouts.admin')

@section('title', 'Zentify | Tambah Album')

<link rel="stylesheet" href="{{ asset('admin/css/albums/album-create.css') }}">
@section('content')
    <div class="container">
        <h1 class="mb-4">Tambah Album Baru</h1>

        {{-- Menampilkan pesan error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.albums.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Judul Album</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
            </div>
            <div class="mb-3">
                <label for="artist_id" class="form-label">Artis</label>
                <select name="artist_id" class="form-control" id="artist_id">
                    <option value="">Pilih Artis</option>
                    @foreach ($artists as $artist)
                        <option value="{{ $artist->id }}" {{ old('artist_id') == $artist->id ? 'selected' : '' }}>
                            {{ $artist->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Album</button>
        </form>
    </div>
@endsection
