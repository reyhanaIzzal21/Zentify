@extends('layouts.user')

@section('title', 'Zentify - Playlist')

<link rel="stylesheet" href="{{ asset('user/css/playlists/playlist-index.css') }}">

@section('content')
    <form action="{{ route('user.playlists.index') }}" method="GET" class="search-bar">
        <button class="btn btn-primary" type="submit">
            <img src="{{ asset('item/search-icon.png') }}" alt="">
        </button>
        <input type="text" name="search" class="form-search" placeholder="Cari playlist..."
            value="{{ request('search') }}">
    </form>

    <div class="container-playlist">
        <div class="header">
            <h3><a href="{{ url('playlists') }}">Playlist</a></h3>
            <div class="btn-cp-np">
                <a href="{{ url('songs') }}" class="btn-next-playlist"><i class="fa-solid fa-arrow-left"></i>
                    <p class="back-to-songs">Kembali</p>
                </a>
                <a href="{{ route('user.playlists.create') }}" class="btn-cp btn-primary mt-3"><i
                        class="fa-solid fa-plus"></i>
                    <p>Buat Playlist</p>
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="content">
            @if ($playlists->isEmpty())
                <p>Lagu yang anda cari tidak ditemukan...</p>
            @else
                @forelse($playlists as $playlist)
                    <a href="{{ route('user.playlists.show', $playlist->id) }}" class="col-md-4">
                        <div class="card mb-4">
                            @if ($playlist->image_path)
                                <img src="{{ asset('storage/' . $playlist->image_path) }}" class="card-img-top"
                                    alt="{{ $playlist->name }}">
                            @else
                                <img src="{{ asset('item/default-image.jpg') }}" class="card-img-top" alt="No Image">
                            @endif
                            <h2 class="card-title">{{ $playlist->name }}</h2>
                        </div>
                    </a>
                @empty
                    <p class="placeholder-no-playlist">Kamu Belum Memiliki Playlist. <a
                            href="{{ route('user.playlists.create') }}">Buat Playlist Pertama Kamu!</a></p>
                @endforelse
            @endif
        </div>
    </div>


@endsection
