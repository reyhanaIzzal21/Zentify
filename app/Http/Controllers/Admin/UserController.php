<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required|string|in:admin,user',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'email.unique' => 'Nama email sudah digunakan oleh user lain.',
                'email.required' => 'Email wajib diisi.',
            ]
        );

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->usertype = $validatedData['role'];
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Berhasil mengupdate user.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Berhasil menghapus user.');
    }
}
