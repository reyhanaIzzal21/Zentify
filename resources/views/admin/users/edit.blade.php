@extends('layouts.admin')


@section('title')
Zentify | Edit User {{ $user->name}}
@endsection

<link rel="stylesheet" href="{{ asset('admin/css/user/user-edit.css')}}">
@section('content')
<div class="container">
    <h1 class="mb-4">Edit User {{ $user->name}}</h1>

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

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-control" id="role">
                <option value="admin" {{ old('role', $user->usertype) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role', $user->usertype) == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
