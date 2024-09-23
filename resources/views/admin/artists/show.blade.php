@extends('layouts.admin')

@section('title')
Zentify | Detail {{ $artist->name}}
@endsection

<link rel="stylesheet" href="{{ asset('admin/css/artists/artist-show.css')}}">

@section('content')
<div class="container mx-auto">
    {{-- Menampilkan pesan error --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container-content">
        <div class="mb-4 text-center">
            @if($artist->photo)
                <div class="photo">
                    <img src="{{ Storage::url('photos/' . $artist->photo) }}" alt="{{ $artist->name }}">
                </div>
            @else
                <span>No Photo</span>
            @endif
        </div>

        <div class="text-item">
            <h4>Detail Artis</h4>
            
            <div class="mb-4 name">
                <p>{{ $artist->name }}</p>
            </div>
        
            <div class="mb-4 bio">
                <strong>Bio:</strong>
                <p>{{ $artist->bio }}</p>
            </div>
        </div>
    </div>
    
    <div class="text-center btn">
        <a href="{{ route('admin.artists.index') }}" class="bg-gray-500">Kembali</a>
        <a href="{{ route('admin.artists.edit', $artist->id) }}" class="bg-yellow-500">Edit</a>
        <form action="{{ route('admin.artists.destroy', $artist->id) }}" method="POST" class="inline"  onsubmit="return confirmDelete()">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500">Hapus</button>
        </form>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Apakah kamu yakin untuk menghapus?');
    }
</script>
@endsection
