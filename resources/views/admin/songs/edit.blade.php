@extends('layouts.admin')

@section('content')

@section('title', 'Zentify | Edit Lagu')

<link rel="stylesheet" href="{{ asset('admin/css/songs/song-edit.css')}}">

<div class="container">
    <h1 class="mb-4">Edit Lagu {{ $song->title }}</h1>

    <!-- Alert untuk menampilkan pesan error -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.songs.update', $song->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Judul Lagu</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $song->title) }}">
        </div>
        <div class="mb-3">
            <label for="artist_id" class="form-label">Artis</label>
            <select name="artist_id" class="form-control" id="artist_id">
                @foreach($artists as $artist)
                    <option value="{{ $artist->id }}" {{ old('artist_id', $song->artist_id) == $artist->id ? 'selected' : '' }}>{{ $artist->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="album_id" class="form-label">Album</label>
            <select name="album_id" class="form-control" id="album_id">
                <option value="">None</option>
                @foreach($albums as $album)
                    <option value="{{ $album->id }}" {{ old('album_id', $song->album_id) == $album->id ? 'selected' : '' }}>{{ $album->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="genre_id" class="form-label">Genre</label>
            <select name="genre_id" class="form-control" id="genre_id">
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ old('genre_id', $song->genre_id) == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="file_path" class="form-label">Upload File Lagu Baru ( harus berformat mp3 )</label>
            <input type="file" name="file_path" class="form-control" id="file_path">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Foto Lagu Baru</label>
            <input type="file" name="image" class="form-control" id="image">
        </div>

        @if($song->image_path)
            <div>
                <img src="{{ asset('storage/' . $song->image_path) }}" alt="{{ $song->title }}" width="100">
            </div>
        @endif
        
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Update Lagu
        </button>
    </form>
</div>
@endsection
