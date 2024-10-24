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
        $artists = Artist::all();
        return view('admin.albums.create', compact('artists'));
    }

    public function store(Request $request)
    {
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

        Album::create($validatedData);

        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil dibuat.');
    }

    public function show(Album $album)
    {
        return view('admin.albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        $artists = Artist::all();
        return view('admin.albums.edit', compact('album', 'artists'));
    }

    public function update(Request $request, Album $album)
    {
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

        $album->update($validatedData);

        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(Album $album)
    {
        if ($album->songs()->count() > 0) {
            return redirect()->route('admin.albums.index')->with('error', 'Album ini tidak bisa dihapus karena ada lagu yang terkait.');
        }

        $album->delete();

        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil dihapus.');
    }
}
