<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Song::with('artist');

        if (request()->has('search')) {
            $search = request()->get('search');
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhereHas('artist', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }

        $songs = $query->latest()->get();

        return view('welcome', compact('songs'));
    }

    public function show($id)
    {
        $song = Song::findOrFail($id);
        return view('showSong', compact('song'));
    }
}
