<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $songs = Song::with(['artist', 'album', 'genre'])
            ->whereHas('artist', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('album', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->orWhereHas('genre', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhere('title', 'like', '%' . $search . '%')
            ->get();

        return view('admin.songs.index', compact('songs', 'search'));
    }

    public function create()
    {
        $artists = Artist::all();
        $albums = Album::all();
        $genres = Genre::all();
        return view('admin.songs.create', compact('artists', 'albums', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'artist_id' => 'required|integer',
                'album_id' => 'required|nullable|integer',
                'genre_id' => 'required|integer',
                'file_path' => 'required|file|mimes:mp3,wav|max:1024000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
            ],
            [
                'title.required' => 'Judul lagu wajib diisi.',
                'artist_id.required' => 'Nama Artis wajib diisi.',
                'album_id.required' => 'Album wajib dipilih.',
                'genre_id.required' => 'Genre wajib dipilih.',
                'file_path.required' => 'File lagu wajib diisi.',
                'file_path.mimes' => 'File harus berupa format mp3 atau wav',
                'image.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
                'image.image' => 'Gambar tidak valid.',
                'image.max' => 'Gambar tidak boleh lebih besar dari 2MB.',
            ]
        );

        $filePath = $request->file('file_path')->store('songs', 'public');

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('song_images', 'public')
            : null;

        Song::create([
            'title' => $request->input('title'),
            'artist_id' => $request->input('artist_id'),
            'album_id' => $request->input('album_id'),
            'genre_id' => $request->input('genre_id'),
            'file_path' => $filePath,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.songs.index')->with('success', 'Berhasil Menambahkan Lagu.');
    }

    public function show($id)
    {
        $song = Song::with(['artist', 'album', 'genre'])->findOrFail($id);
        return view('admin.songs.show', compact('song'));
    }

    public function edit($id)
    {
        $song = Song::findOrFail($id);
        $artists = Artist::all();
        $albums = Album::all();
        $genres = Genre::all();
        return view('admin.songs.edit', compact('song', 'artists', 'albums', 'genres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'artist_id' => 'required|integer',
                'album_id' => 'required|nullable|integer',
                'genre_id' => 'required|integer',
                'file_path' => 'nullable|file|mimes:mp3,wav|max:1024000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20000',
            ],
            [
                'title.required' => 'Judul lagu wajib diisi.',
                'artist_id.required' => 'Nama Artis wajib diisi.',
                'album_id.required' => 'Album wajib dipilih.',
                'genre_id.required' => 'Genre wajib dipilih.',
                'file_path.mimes' => 'Format file harus berupa mp3 atau wav.',
                'image.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
                'image.image' => 'Gambar tidak valid.',
                'image.max' => 'Gambar tidak boleh lebih besar dari 2MB.',
            ]
        );

        $song = Song::findOrFail($id);

        if ($request->hasFile('file_path')) {
            Storage::disk('public')->delete($song->file_path);
            $filePath = $request->file('file_path')->store('songs', 'public');
            $song->file_path = $filePath;
        }

        if ($request->hasFile('image')) {
            if ($song->image_path) {
                Storage::disk('public')->delete($song->image_path);
            }
            $imagePath = $request->file('image')->store('song_images', 'public');
            $song->image_path = $imagePath;
        }

        $song->title = $request->input('title');
        $song->artist_id = $request->input('artist_id');
        $song->album_id = $request->input('album_id');
        $song->genre_id = $request->input('genre_id');
        $song->save();

        return redirect()->route('admin.songs.index')->with('success', 'Lagu Berhasil Diedit.');
    }

    public function destroy($id)
    {
        $song = Song::findOrFail($id);

        if ($song->file_path) {
            Storage::disk('public')->delete($song->file_path);
        }

        if ($song->image_path) {
            Storage::disk('public')->delete($song->image_path);
        }

        $song->delete();

        return redirect()->route('admin.songs.index')->with('success', 'Lagu dan File terkait berhasil dihapus.');
    }
}
