@extends('layouts.admin')

@section('content')

@section('title', 'Zentify | Admin Dashboard')

<link rel="stylesheet" href="{{ asset('admin/css/dashboard-index.css') }}">
<h1 class="h1-header">DASHBOARD ADMIN /</h1>

<section class="container">
    {{-- Kartu Statistik Singkat --}}
    <div class="card">
        <div class="card-content">
            <h3>Total Lagu</h3>
            <p>{{ $songCounts ? array_sum($songCounts) : 0 }}</p>
        </div>

        <div class="card-content">
            <h3>Total Artis</h3>
            <p>{{ $artistCounts ? array_sum($artistCounts) : 0 }}</p>
        </div>

        <div class="card-content">
            <h3>Total User</h3>
            <p>{{ $userCounts ? array_sum($userCounts) : 0 }}</p>
        </div>
    </div>

    <div class="card-two">
        <div class="card-content">
            <h3>Album</h3>
            <ol>
                @foreach ($albums as $album)
                    <li>{{ $album->title }} oleh {{ $album->artist->name }}</li>
                @endforeach
            </ol>
        </div>
        <div class="card-content">
            <h3>Genre</h3>
            <ol>
                @foreach ($genres as $genre)
                    <li>{{ $genre->name }}: {{ $genre->songs_count }} lagu</li>
                @endforeach
            </ol>
        </div>
    </div>




    {{-- Chart data lagu --}}
    <div class="chart-item">
        <div class="chart-container">
            <h3>Jumlah Lagu Yang Bertambah per Bulan</h3>
            <canvas id="songsChart" width="400" height="120"></canvas>
        </div>
    </div>

    {{-- Chart data artist dan user --}}
    <div class="chart-item">
        <div class="chart-container">
            <h3>Jumlah Artis dan User Yang Bertambah per Minggu</h3>
            <canvas id="artistsUsersChart" width="400" height="150"></canvas>
        </div>
    </div>
</section>


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var months = @json($months); // Mengambil data bulan
            var songCounts = @json($songCounts); // Mengambil data jumlah lagu

            var ctx = document.getElementById('songsChart').getContext('2d');

            var chartData = {
                labels: months.map(month => `${month}`), // Menampilkan bulan dalam format string
                datasets: [{
                    label: 'Jumlah Lagu',
                    data: songCounts, // Data jumlah lagu per bulan
                    backgroundColor: '#858585',
                    borderColor: '#0060E0',
                    borderWidth: 2,
                    // tension: 0.4
                }]
            };

            var myChart = new Chart(ctx, {
                type: 'bar', // Jenis chart
                data: chartData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true // Mulai dari angka 0
                        }
                    }
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var weeks = @json($weeks); // Mengambil data minggu (label)
            var artistCounts = @json($artistCounts); // Mengambil data jumlah artist per minggu
            var userCounts = @json($userCounts); // Mengambil data jumlah user per minggu

            var ctx = document.getElementById('artistsUsersChart').getContext('2d'); // Ubah id canvas

            var chartData = {
                labels: weeks, // Menampilkan label minggu
                datasets: [{
                        label: 'Artis',
                        data: artistCounts, // Data jumlah artist per minggu
                        backgroundColor: '#858585',
                        borderColor: '#0060E0',
                        borderWidth: 2,
                        tension: 0.4 // Membuat garis lebih halus
                    },
                    {
                        label: 'User',
                        data: userCounts, // Data jumlah user per minggu
                        backgroundColor: '#858585',
                        borderColor: '#ff0000',
                        borderWidth: 2,
                        tension: 0.4 // Membuat garis lebih halus
                    }
                ]
            };

            var myChart = new Chart(ctx, {
                type: 'line', // Jenis chart
                data: chartData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true // Mulai dari angka 0
                        }
                    }
                }
            });
        });
    </script>

@endsection

@endsection
