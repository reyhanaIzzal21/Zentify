<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|unique:genres,name|max:255',
            ],
            [
                'name.required' => 'Nama genre wajib di isi.',
                'name.unique' => 'Nama genre sudah ada, silahkan pilih nama yang lain.',
            ]
        );

        // Menyimpan genre
        Genre::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.genres.index')->with('success', 'Berhasil membuat genre baru.');
    }

    public function show(Genre $genre)
    {
        return view('admin.genres.show', compact('genre'));
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        // Validasi data
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255|unique:genres,name,' . $genre->id,
            ],
            [
                'name.required' => 'Nama genre wajib di isi.',
                'name.unique' => 'Nama genre sudah ada, silahkan pilih nama yang lain.',
            ]
        );

        // Memperbarui genre
        $genre->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.genres.index')->with('success', 'Berhasil mengedit nama genre.');
    }

    public function destroy(Genre $genre)
    {
        // Cek apakah artis sedang digunakan di tabel songs
        if ($genre->songs()->count() > 0) {
            // Jika artis terkait dengan satu atau lebih lagu, tampilkan pesan kesalahan
            return redirect()->route('admin.genres.index')
                ->with('error', 'Genre ini tidak bisa dihapus karena ada lagu yang terkait.');
        }

        $genre->delete();
        return redirect()->route('admin.genres.index')->with('success', 'Berhasil menghapus genre.');
    }
}
