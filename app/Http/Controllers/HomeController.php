<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Fungsi untuk menampilkan halaman welcome
    public function welcome()
    {
        // Ambil semua lagu dari database
        $songs = Song::all();

        // Kirim data lagu ke view welcome.blade.php
        return view('welcome', compact('songs'));
    }
}
