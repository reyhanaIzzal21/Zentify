<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlaylistController extends Controller
{
    public function index(Request $request)
    {
        $query = Playlist::where('user_id', Auth::id());

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        $playlists = $query->latest()->get();

        return view('user.playlists.index', compact('playlists'));
    }


    public function create()
    {
        $songs = Song::all();
        return view('user.playlists.create', compact('songs'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:200000',
                'songs' => 'nullable|array',
                'songs.*' => 'exists:songs,id',
            ],
            [
                'name.required' => 'Nama playlist wajib diisi.',
                'image.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
                'image.image' => 'Gambar tidak valid.',
            ]
        );

        $playlist = new Playlist();
        $playlist->name = $request->input('name');
        $playlist->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('playlists', 'public');
            $playlist->image_path = $imagePath;
        }

        $playlist->save();

        if ($request->has('songs')) {
            $playlist->songs()->sync($request->songs);
        }

        return redirect()->route('user.playlists.show', $playlist->id)->with('success', 'Playlist Berhasil Di Buat');
    }

    public function edit(Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            return redirect()->route('user.playlists.index')->with('error', 'Unauthorized action');
        }

        $songs = Song::all();
        return view('user.playlists.edit', compact('playlist', 'songs'));
    }

    public function update(Request $request, Playlist $playlist)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:200000',
                'songs' => 'nullable|array',
                'songs.*' => 'exists:songs,id',
            ],
            [
                'name.required' => 'Nama playlist wajib diisi.',
                'image.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
                'image.image' => 'Gambar tidak valid.',
            ]
        );

        $playlist->name = $request->input('name');

        if ($request->hasFile('image')) {
            if ($playlist->image_path) {
                Storage::disk('public')->delete($playlist->image_path);
            }

            $imagePath = $request->file('image')->store('playlists', 'public');
            $playlist->image_path = $imagePath;
        }

        $playlist->save();

        if ($request->has('songs')) {
            $playlist->songs()->sync($request->songs);
        } else {
            $playlist->songs()->sync([]);
        }

        return redirect()->route('user.playlists.show', $playlist->id)->with('success', 'Playlist Berhasil Di Perbarui');
    }

    public function destroy(Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            return redirect()->route('user.playlists.index')->with('error', 'Unauthorized action');
        }

        if ($playlist->image_path) {
            Storage::disk('public')->delete($playlist->image_path);
        }

        $playlist->delete();

        return redirect()->route('user.songs.index')->with('success', 'Playlist Berhasil Di Hapus');
    }

    public function show(Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            return redirect()->route('user.playlists.index')->with('error', 'Unauthorized action');
        }

        $songs = $playlist->songs;

        return view('user.playlists.show', compact('playlist', 'songs'));
    }
}
