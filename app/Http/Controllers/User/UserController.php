<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Playlist;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        return view('user.dashboard');
    }


    public function songs()
    {
        $songs = Song::all();
        $songs = Song::with('artist')->get();

        $playlists = Playlist::where('user_id', Auth::id())->get();
        return view('user.songs.index', compact('songs', 'playlists'));
    }

    public function showSong($id)
    {
        $song = Song::findOrFail($id);
        return view('user.songs.show', compact('song'));
    }
}
