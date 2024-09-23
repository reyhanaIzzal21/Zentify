<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{

    public function welcome()
    {
        $songs = Song::with('artist')->get();
        return view('welcome', compact('songs'));
    }

    public function index(Request $request)
    {
        $query = Song::with('artist'); // Ambil data lagu dengan relasi artist

        // Jika ada parameter 'search', tambahkan filter untuk pencarian
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhereHas('artist', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }

        // Ambil semua lagu beserta artisnya
        $songs = $query->get();

        // Ambil semua playlist yang dimiliki user
        $playlists = Playlist::where('user_id', Auth::id())->get();

        return view('user.songs.index', compact('songs', 'playlists'));
    }







    public function show(Song $song)
    {
        // Memuat relasi album, artist, dan genre
        $song->load(['album', 'artist', 'genre']);

        return view('user.songs.show', compact('song'));
    }


    // Metode create, store, edit, update, destroy mungkin tidak diperlukan untuk SongController di sisi user.
    // Pengguna biasanya hanya melihat daftar lagu atau menambahkannya ke playlist mereka.
}
