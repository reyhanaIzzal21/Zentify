@extends('layouts.admin')

@section('title', 'Edit Genre')

<link rel="stylesheet" href="{{asset('admin/css/genres/genre-edit.css')}}">
@section('content')
<div class="container">
    <h1 class="mb-4">Edit Genre</h1>

    {{-- Menampilkan pesan error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.genres.update', $genre->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Genre</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $genre->name) }}">
        </div>
        <button type="submit" class="btn btn-success">Update Genre</button>
    </form>
</div>
@endsection
