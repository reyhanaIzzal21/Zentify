<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artist;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::all();
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        $artists = Artist::all(); // Mengambil semua data artist
        return view('admin.albums.create', compact('artists'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate(
            [
                'title' => 'required|string|max:255',
                'artist_id' => 'required|integer|exists:artists,id',
            ],
            [
                'title.required' => 'Judul Album wajib diisi.',
                'artist_id.required' => 'Nama Artis wajib dipilih.',
            ]
        );

        // Menyimpan album
        Album::create($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil dibuat.');
    }

    public function show(Album $album)
    {
        return view('admin.albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        $artists = Artist::all(); // Mengambil semua data artist untuk view edit
        return view('admin.albums.edit', compact('album', 'artists'));
    }

    public function update(Request $request, Album $album)
    {
        // Validasi data
        $validatedData = $request->validate(
            [
                'title' => 'required|string|max:255',
                'artist_id' => 'required|integer|exists:artists,id',
            ],
            [
                'title.required' => 'Judul Album wajib diisi.',
                'artist_id.required' => 'Nama Artis wajib dipilih.',
            ]
        );

        // Memperbarui album
        $album->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(Album $album)
    {
        // Periksa apakah album memiliki lagu yang terkait
        if ($album->songs()->count() > 0) {
            // Jika ada lagu yang terkait, tidak bisa dihapus
            return redirect()->route('admin.albums.index')->with('error', 'Album ini tidak bisa dihapus karena ada lagu yang terkait.');
        }

        // Jika tidak ada lagu yang terkait, hapus album
        $album->delete();

        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil dihapus.');
    }
}
