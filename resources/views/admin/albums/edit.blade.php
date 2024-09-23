@extends('layouts.admin')

@section('title', 'Zentify | Edit Album')

<link rel="stylesheet" href="{{ asset('admin/css/albums/album-edit.css')}}">
@section('content')
<div class="container">
    <h1 class="mb-4">Edit Album</h1>

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

    <form action="{{ route('admin.albums.update', $album->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Judul Album</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $album->title) }}">
        </div>
        <div class="mb-3">
            <label for="artist_id" class="form-label">Artis</label>
            <select name="artist_id" class="form-control" id="artist_id">
                @foreach($artists as $artist)
                    <option value="{{ $artist->id }}" {{ old('artist_id', $album->artist_id) == $artist->id ? 'selected' : '' }}>{{ $artist->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Album</button>
    </form>
</div>
@endsection
