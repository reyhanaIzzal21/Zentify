@extends('layouts.admin')

@section('content')

@section('title')
Zentify | Detail Lagu {{ $song->title }}
@endsection

<link rel="stylesheet" href="{{ asset('admin/css/songs/song-show.css')}}">

<div class="container">
    <div class="card-body">
        <div class="img">
            @if($song->image_path)
                <img src="{{ asset('storage/' . $song->image_path) }}" alt="{{ $song->title }}" >
            @else
                <p class="text-muted">No Image Available</p>
            @endif
        </div>
        <div class="item">
            <p>Single</p>
            <h2 class="card-title">{{ $song->title }}</h2>
            <p class="card-text">By: {{ $song->artist->name }}</p>
            <div class="item-two">
                <p class="card-text">Album: {{ $song->album->title }}</p>
                <p class="card-text">Genre: {{ $song->genre->name }}</p>
            </div>
        </div>
    </div>
    <div class="audio-control">
        <audio controls>
            <source src="{{ asset('storage/' . $song->file_path) }}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>

        <div class="actions mt-3">
            <a href="{{ route('admin.songs.edit', $song->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('admin.songs.destroy', $song->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmDelete()">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Apakah kamu yakin untuk menghapus?');
    }
</script>

@endsection
