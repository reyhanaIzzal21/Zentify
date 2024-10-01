@extends('layouts.app')

@section('title', 'Zentify | Home')

<link rel="stylesheet" href="{{ asset('user/css/welcome-style.css') }}">
@section('content')
    <header>
        <a href="{{ url('/songs') }}">
            <img src="{{ asset('item/logo.png') }}" alt="logo Zentify" class="logo">
        </a>

        <form action="{{ route('user.songs.index') }}" method="GET" class="search-bar">
            <button class="btn btn-primary" type="submit">
                <img src="{{ asset('item/search-icon.png') }}" alt="">
            </button>
            <input type="text" name="search" placeholder="Cari lagu atau artis..."
                value="{{ request()->get('search') }}" class="form-search">
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

    @if (session('success'))
        <div class="alert alert-success">
            <p><i class="fas fa-check-circle"></i> {{ session('success') }}</p>
        </div>
    @endif

    <section class="container-main-songs">
        <div class="songs-container">
            @foreach ($songs as $song)
                <div class="song-card" onclick="playSelectedSong({{ $loop->index }})">
                    <div class="song-image">
                        <a href="{{ route('user.songs.index') }}" class="text-blue-500">
                            @if ($song->image_path)
                                <img src="{{ asset('storage/' . $song->image_path) }}" alt="{{ $song->title }}">
                            @else
                                <img src="{{ asset('item/default-image.jpg') }}" alt="No Image">
                            @endif

                            <button class="play-pause-btn" id="play-pause-btn-{{ $loop->index }}"
                                onclick="toggleCardPlayPause(event, {{ $loop->index }})">
                                <i class="fas fa-play"></i>
                            </button>
                        </a>
                    </div>
                    <div class="song-details">
                        <a href="{{ route('user.songs.index') }}" class="text-blue-500">
                            <h3>{{ $song->title }}</h3>
                        </a>
                        <p>By {{ $song->artist->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="footer">
            @include('layouts.partials.footer-user')
        </div>
    </section>
@endsection
