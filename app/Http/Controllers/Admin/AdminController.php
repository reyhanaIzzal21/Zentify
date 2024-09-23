<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Song;
use App\Models\Artist;
use App\Models\User;
use App\Models\Album;
use App\Models\Genre;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Query untuk mendapatkan jumlah lagu per bulan (sudah ada)
        $songs = Song::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Buat array untuk semua bulan dalam satu tahun
        $months = range(1, 12);
        $songCounts = array_fill(1, 12, 0); // Inisialisasi semua bulan dengan 0

        // Mengisi jumlah lagu untuk bulan yang ada data
        foreach ($songs as $song) {
            $songCounts[$song->month] = $song->count;
        }

        // Ambil data 1 tahun ke belakang, mulai dari 1 Januari tahun ini
        $startDate = Carbon::create(Carbon::now()->year, 1, 1); // Awal tahun ini (1 Januari)
        $endDate = Carbon::create(Carbon::now()->year, 12, 31); // Akhir tahun ini (31 Desember)

        // Buat array untuk menyimpan data per minggu selama 52 minggu
        $weeklyData = [];
        $weeklyArtistData = [];
        $weeklyUserData = []; // Untuk data user

        // Looping setiap minggu selama 52 minggu (1 tahun)
        $currentWeek = $startDate->copy(); // Mulai dari minggu pertama tahun ini
        while ($currentWeek <= $endDate) {
            // Tentukan awal dan akhir minggu ini
            $startOfWeek = $currentWeek->copy()->startOfWeek(); // Awal minggu (Senin)
            $endOfWeek = $currentWeek->copy()->endOfWeek();     // Akhir minggu (Minggu)

            // Hitung jumlah artist dan user yang ditambahkan pada minggu ini
            $artistCount = Artist::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
            $userCount = User::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count(); // Hitung jumlah user

            // Simpan data minggu, jumlah artist, dan user
            $weeklyData[] = [
                'week' => $startOfWeek->format('d M') . ' - ' . $endOfWeek->format('d M'),
                'artistCount' => $artistCount,
                'userCount' => $userCount, // Tambahkan jumlah user
            ];

            // Pindah ke minggu berikutnya
            $currentWeek->addWeek();
        }

        // Pisahkan label minggu, data jumlah artist, dan data jumlah user
        $weeks = array_column($weeklyData, 'week');
        $artistCounts = array_column($weeklyData, 'artistCount');
        $userCounts = array_column($weeklyData, 'userCount'); // Data jumlah user

        // Ambil data Album dan Genre
        $albums = Album::with('artist')->get();
        $genres = Genre::withCount('songs')->get();

        // Kirim data ke view
        return view('admin.dashboard', [
            'months' => $months,
            'songCounts' => $songCounts, // Ubah variabel ini untuk lagu
            'weeks' => $weeks,
            'artistCounts' => $artistCounts, // Ubah variabel ini untuk artist
            'userCounts' => $userCounts,  // Tambahkan variabel untuk user
            'albums' => $albums,
            'genres' => $genres
        ]);
    }
}
