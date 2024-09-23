<?php

namespace App\Http\Controllers;

use App\Models\Song;

abstract class Controller
{
    public function welcome()
    {
        $songs = Song::with('artist')->get(); // Mengambil semua lagu beserta artist-nya
        return view('welcome', compact('songs'));
    }
}
