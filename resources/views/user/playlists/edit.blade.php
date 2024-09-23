@extends('layouts.user')

@section('title', 'Zentify - Edit Playlist: ' . $playlist->name)

<link rel="stylesheet" href="{{ asset('user/css/playlists/playlist-edit.css')}}">
@section('content')
<div class="container">
    <h1>Edit Playlist</h1>

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

    <form action="{{ route('user.playlists.update', $playlist->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mt-3">
            <label for="name">Nama Playlist</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $playlist->name) }}" >
        </div>

        <div class="form-group mt-3">
            <label for="image">Foto Playlist</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($playlist->image_path)
                <img src="{{ asset('storage/' . $playlist->image_path) }}" alt="Playlist Image" class="img-thumbnail mt-2" width="150">
            @endif
        </div>

        <div class="form-group mt-3">
            <label for="songs">Tambah Lagu</label>
            <select name="songs[]" id="songs" class="form-control" multiple>
                @foreach($songs as $song)
                    <option value="{{ $song->id }}"
                        {{ in_array($song->id, old('songs', $playlist->songs->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $song->title }} by {{ $song->artist->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Playlist</button>
    </form>
</div>
@endsection
