@extends('layouts.admin')

@section('title', 'Zentify | Edit Artis')

<link rel="stylesheet" href="{{ asset('admin/css/artists/artist-edit.css')}}">

@section('content')
<div class="container mx-auto">
    <h2>Edit Artis</h2>

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name">Nama Artis:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $artist->name) }}">
        </div>

        <div class="mb-4">
            <label for="bio">Bio Artis:</label>
            <textarea name="bio" id="bio" rows="5">{{ old('bio', $artist->bio) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="photo">Foto Artis:</label>
            @if($artist->photo)
                <div>
                    <img src="{{ Storage::url('photos/' . $artist->photo) }}" alt="{{ $artist->name }}">
                </div>
            @endif
            <input type="file" name="photo" id="photo">
        </div>

        <div class="mb-4">
            <button type="submit">Update</button>
            <a href="{{ route('admin.artists.index') }}">Batal</a>
        </div>
    </form>
</div>
@endsection
