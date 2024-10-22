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
        $query = Song::with('artist');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhereHas('artist', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }

        $songs = $query->latest()->get();

        $playlists = Playlist::where('user_id', Auth::id())->latest()->get();

        return view('user.songs.index', compact('songs', 'playlists'));
    }

    public function showSong($id)
    {
        $song = Song::findOrFail($id);
        return view('user.songs.show', compact('song'));
    }
}
