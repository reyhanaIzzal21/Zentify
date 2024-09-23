
@extends('layouts.admin')

@section('content')

@section('title', 'Zentify | Daftar Genre')

<link rel="stylesheet" href="{{ asset('admin/css/genres/genre-index.css')}}">
<div class="container mx-auto py-8">
    <div class="header">
        <h1 class="text-2xl font-semibold text-white mb-6">Daftar Genre</h1>
        <a href="{{ route('admin.genres.create') }}" >
            <button class="button">
                <span class="liquid"></span>  
                <span class="btn-txt">Tambah Genre Baru</span>
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

    @if($genres->isEmpty())
        <p class="text-white">No genres found.</p>
    @else
        <table class="genre-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($genres as $genre)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $genre->name }}</td>
                        <td>
                            <a href="{{ route('admin.genres.show', $genre->id) }}" class="btn-action view"><i class="fas fa-eye"></i> </a>
                            {{-- <a href="{{ route('admin.genres.edit', $genre->id) }}" class="btn-action edit"><i class="fas fa-edit"></i> </a>
                            <form action="{{ route('admin.genres.destroy', $genre->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action delete"><i class="fas fa-trash-alt"></i> </button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
