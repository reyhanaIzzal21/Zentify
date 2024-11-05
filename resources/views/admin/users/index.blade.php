@extends('layouts.admin')

@section('content')

@section('title', 'Zentify | Daftar User')

<link rel="stylesheet" href="{{ asset('admin/css/user/user-index.css') }}">
<div class="container mx-auto py-8">
    <h1>DASHBOARD ADMIN <span>/ USER</span></h1>

    <table class="user-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->usertype }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-action edit"><i
                                class="fas fa-edit"></i> </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                            style="display:inline-block;" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action delete"><i class="fas fa-trash-alt"></i> </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function confirmDelete() {
        return confirm('Apakah kamu yakin untuk menghapus?');
    }
</script>
@endsection
