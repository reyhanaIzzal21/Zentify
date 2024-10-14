@extends('layouts.app')

@section('title', 'Detail Lagu - Zentify: ' . $song->title)

<link rel="stylesheet" href="{{ asset('user/css/song-show.css') }}">
@section('content')
    <header>
        <a href="{{ url('/songs') }}">
            <img src="{{ asset('item/logo.png') }}" alt="logo Zentify" class="logo">
        </a>

        <form action="{{ route('welcome') }}" method="GET" class="search-bar">
            <button class="btn btn-primary" type="submit">
                <img src="{{ asset('item/search-icon.png') }}" alt="">
            </button>
            <input type="text" name="search" placeholder="Cari lagu atau artis..." value="{{ request('search') }}"
                class="form-search">
        </form>

        @if (Route::has('login'))
            <nav>
                @auth
                    <a href="{{ url('/songs') }}">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        Masuk
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="register">
                            Daftar
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <div class="container">
        <div class="card">
            <div class="song-card">
                @if ($song->image_path)
                    <img id="audio-thumbnail" src="{{ asset('storage/' . $song->image_path) }}" alt="{{ $song->title }}"
                        class="img-fluid thumbnail">
                @else
                    <img src="{{ asset('item/default-image.jpg') }}" alt="No Image" class="img-fluid">
                @endif
            </div>
            <div class="detail-song">
                <p class="single">Single</p>
                <h1>{{ $song->title }}</h1>
                <div class="detail-song-aag">
                    <p class="artist-name">By• {{ $song->artist->name }}</p>
                    <p>Album: {{ $song->album->title }}</p>
                    <p>Genre: {{ $song->genre->name }}</p>
                </div>
            </div>
        </div>

        <div class="song-list">
            @php
                $no = 1;
            @endphp
            <table>
                <thead>
                    <tr>
                        <th class="no">#</th>
                        <th>Judul</th>
                        <th>Album</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="no">{{ $no++ }}</td>
                        <td>
                            <p class="name-artist">{{ $song->title }}</p>
                            <p>{{ $song->artist->name }}</p>
                        </td>
                        <td>{{ $song->album->title }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
