@extends('layouts.user')

@section('title', 'Zentify - Buat Playlist')

<link rel="stylesheet" href="{{asset('user/css/playlists/playlist-create.css')}}">
@section('content')
<div class="container">
    <h1>Tambah Playlist</h1>

    {{-- Menampilkan pesan error jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.playlists.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mt-3">
            <label for="name">Nama Playlist</label>
            <input type="text" name="name" id="name" class="form-control" >
        </div>

        <div class="form-group mt-3">
            <label for="image">Foto Playlist</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="form-group mt-3">
            <label for="songs">Tambah Lagu</label>
            <select name="songs[]" id="songs" class="form-control" multiple>
                @foreach($songs as $song)
                    <option value="{{ $song->id }}" {{ in_array($song->id, old('songs', [])) ? 'selected' : '' }}>
                        {{ $song->title }} by {{ $song->artist->name }}
                    </option>
                @endforeach
            </select>
        </div>
        

        <button type="submit" class="btn btn-primary mt-3">Buat Playlist</button>
    </form>
</div>
@endsection
