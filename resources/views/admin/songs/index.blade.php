@extends('layouts.admin')

@section('content')

@section('title', 'Zentify | Daftar Lagu')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('admin/css/songs/song-index.css') }}">

<div class="container">
    <div class="header">
        <h1>DASHBOARD ADMIN <span>/ DAFTAR LAGU</span></h1>
        <a href="{{ route('admin.songs.create') }}">
            <button class="button">
                <span class="liquid"></span>
                <span class="btn-txt">Tambah Lagu Baru</span>
            </button>
        </a>
    </div>

    <!-- Search Form -->
    <form action="{{ route('admin.songs.index') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control"
                placeholder="Cari berdasarkan judul, artis, album, dan genre..." value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>

    {{-- Menampilkan pesan error --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Judul Lagu</th>
                    <th>Artis</th>
                    <th>Album</th>
                    <th>Genre</th>
                    <th>Audio</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($songs as $song)
                    <tr>
                        <td>
                            @if ($song->image_path)
                                <img src="{{ asset('storage/' . $song->image_path) }}" alt="{{ $song->title }}"
                                    width="50">
                            @else
                                No Image
                            @endif
                        </td>

                        <td>{{ $song->title }}</td>
                        <td>{{ $song->artist->name }}</td>
                        <td>{{ $song->album->title }}</td>
                        <td>{{ $song->genre->name }}</td>
                        <td>
                            <div class="audio-container">
                                <audio controls>
                                    <source src="{{ asset('storage/' . $song->file_path) }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </td>
                        <td class="actions">
                            <a href="{{ route('admin.songs.show', $song->id) }}" class="btn-action"><i
                                    class="fas fa-eye"></i></a>
                            {{-- <a href="{{ route('admin.songs.edit', $song->id) }}" class="btn-action"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.songs.destroy', $song->id) }}" method="POST" class="form-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action delete"><i class="fas fa-trash-alt"></i></button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
