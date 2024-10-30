@extends('layouts.admin')

@section('content')

@section('title', 'Zentify | Daftar Artis')

<link rel="stylesheet" href="{{ asset('admin/css/artists/artist-index.css')}}">
<div class="container mx-auto py-8">

    <div class="header">
        <h2 class="h2-header">Daftar Artis</h2>

        <a href="{{ route('admin.artists.create') }}" >
            <button class="button">
              <span class="liquid"></span>
              <span class="btn-txt">Tambah Artis Baru</span>
            </button>
        </a>
    </div>

    {{-- Menampilkan pesan error --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="artist-grid">
        @foreach($artists as $artist)
            <div class="artist-card">
                @if($artist->photo)
                    <div class="artist-photo">
                        <img src="{{ Storage::url('photos/' . $artist->photo) }}" alt="{{ $artist->name }}">
                        <div class="overlay">
                            <a href="{{ route('admin.artists.show', $artist->id) }}" class="play-button">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="artist-photo default-photo">No Photo</div>
                @endif
                <div class="artist-info">
                    <h3>{{ $artist->name }}</h3>
                    <p>Artist</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
