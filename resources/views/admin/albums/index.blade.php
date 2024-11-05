@extends('layouts.admin')

@section('content')

@section('title', 'Zentify | Daftar Album')

<link rel="stylesheet" href="{{ asset('admin/css/albums/album-index.css') }}">
<div class="container mx-auto py-8">
    <div class="header">
        <h1>DASHBOARD ADMIN <span>/ ALBUM</span></h1>
        <a href="{{ route('admin.albums.create') }}">
            <button class="button">
                <span class="liquid"></span>
                <span class="btn-txt">Tambah Album Baru</span>
            </button>
        </a>
    </div>

    {{-- Menampilkan pesan error --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($albums->count())
        <table class="album-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Judul</th>
                    <th>Artis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($albums as $album)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $album->title }}</td>
                        <td>{{ $album->artist->name }}</td>
                        <td>
                            <a href="{{ route('admin.albums.show', $album->id) }}" class="btn-action show">Lihat</a>
                            {{-- <a href="{{ route('admin.albums.edit', $album->id) }}" class="btn-action edit">Edit</a>
                            <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action delete" onclick="return confirm('Are you sure?')">Hapus</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-white">No albums found.</p>
    @endif
</div>
@endsection
