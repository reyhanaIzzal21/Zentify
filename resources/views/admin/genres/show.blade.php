@extends('layouts.admin')

@section('title')
Zentify | Detail Genre {{$genre->name}}
@endsection

<link rel="stylesheet" href="{{ asset('admin/css/genres/genre-show.css')}}">
@section('content')
<div class="container">
    <h1 class="mb-4">Genre Details</h1>
    <div class="card">
        <h2 class="card-title">{{ $genre->name }}</h2>
        <div class="card-btn">
            <a href="{{ route('admin.genres.edit', $genre->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.genres.destroy', $genre->id) }}" method="POST" style="display:inline-block;"  onsubmit="return confirmDelete()">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
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
