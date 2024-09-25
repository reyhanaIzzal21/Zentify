@extends('layouts.admin')

@section('title')
    Zentify | Detail Album {{ $album->title }}
@endsection

<link rel="stylesheet" href="{{ asset('admin/css/albums/album-show.css') }}">
@section('content')
    <div class="container">
        <h1 class="mb-4">Detail Album</h1>
        <div class="card">
            <h3 class="card-title">{{ $album->title }}</h3>
            <p class="card-text">By: {{ $album->artist->name }}</p>
            <div class="card-btn">
                <a href="{{ route('admin.albums.edit', $album->id) }}">Edit</a>
                <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST" style="display:inline-block;"
                    onsubmit="return confirmDelete()">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Apakah kamu yakin untuk menghapus Album?')">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endsection
