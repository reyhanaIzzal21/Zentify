@extends('layouts.user')

@section('title', 'Detail Lagu - Zentify: ' . $song->title)

<link rel="stylesheet" href="{{ asset('user/css/song-show.css') }}">
@section('content')
    <div class="container">
        <div class="card">
            <div class="song-card">
                @if ($song->image_path)
                    <img id="audio-thumbnail" src="{{ asset('storage/' . $song->image_path) }}" alt="{{ $song->title }}"
                        class="img-fluid thumbnail">
                @else
                    <img src="{{ asset('item/default-image.jpg') }}" alt="No Image" class="img-fluid">
                @endif
            </div>
            <div class="detail-song">
                <p class="single">Single</p>
                <h1>{{ $song->title }}</h1>
                <div class="detail-song-aag">
                    <p class="artist-name">By• {{ $song->artist->name }}</p>
                    <p>Album: {{ $song->album->title }}</p>
                    <p>Genre: {{ $song->genre->name }}</p>
                </div>
            </div>
        </div>

        <div class="song-list">
            <!-- Tombol Play/Pause di Song Card -->
            <div class="play-pause-card-btn">
                <button id="play-pause-card-btn" class="btn btn-primary" onclick="togglePlayPauseCard()">
                    <i class="fas fa-play"></i>
                </button>
            </div>

            @php
                $no = 1;
            @endphp
            <table>
                <thead>
                    <tr>
                        <th class="no">#</th>
                        <th>Judul</th>
                        <th>Album</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="no">{{ $no++ }}</td>
                        <td>
                            <p class="name-artist">{{ $song->title }}</p>
                            <p>{{ $song->artist->name }}</p>
                        </td>
                        <td>{{ $song->album->title }}</td>
                    </tr>
                </tbody>
            </table>
        </div>


        <div class="col-md-8">
            <!-- Kontrol Audio -->
            <div class="audio-control">
                <div class="audio-info">
                    <img id="audio-thumbnail" src="{{ asset('storage/' . $song->image_path) }}" alt="Song Thumbnail"
                        class="thumbnail">
                    <div class="song-details">
                        <h4 id="audio-title">{{ $song->title }}</h4>
                        <p id="audio-artist">{{ $song->artist->name }}</p>
                    </div>
                </div>

                <div class="audio-player">
                    <div class="btn-ap">
                        <button id="prev-btn"><i class="fas fa-backward"></i></button>
                        <button id="play-pause-btn" onclick="togglePlayPause()">
                            <i class="fas fa-play"></i>
                        </button>
                        <button id="next-btn"><i class="fas fa-forward"></i></button>
                    </div>

                    <div class="progress-bar">
                        <span id="current-time">0:00</span>
                        <input type="range" id="progress" value="0" min="0" max="100"
                            class="styled-range">
                        <span id="duration-time">0:00</span>
                    </div>
                </div>

                <div class="audio-volume">
                    <button id="mute-btn"><i class="fas fa-volume-up"></i></button>
                    <input type="range" id="volume-control" min="0" max="1" step="0.1" value="1"
                        class="volume-slider">
                </div>
            </div>

            <!-- Elemen Audio -->
            <audio id="audio-player">
                <source src="{{ asset('storage/' . $song->file_path) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const audioPlayer = document.getElementById('audio-player');
        const playPauseBtn = document.getElementById('play-pause-btn');
        const playPauseCardBtn = document.getElementById('play-pause-card-btn');
        const progress = document.getElementById('progress');
        const currentTimeDisplay = document.getElementById('current-time');
        const durationTimeDisplay = document.getElementById('duration-time');
        const volumeControl = document.getElementById('volume-control');
        const muteBtn = document.getElementById('mute-btn');

        // Play/Pause toggle di Card
        function togglePlayPauseCard() {
            if (audioPlayer.paused) {
                audioPlayer.play();
                playPauseCardBtn.innerHTML = '<i class="fas fa-pause"></i>';
                playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
            } else {
                audioPlayer.pause();
                playPauseCardBtn.innerHTML = '<i class="fas fa-play"></i>';
                playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
            }
        }

        // Play/Pause toggle di Audio Control
        function togglePlayPause() {
            if (audioPlayer.paused) {
                audioPlayer.play();
                playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                playPauseCardBtn.innerHTML = '<i class="fas fa-pause"></i>';
            } else {
                audioPlayer.pause();
                playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
                playPauseCardBtn.innerHTML = '<i class="fas fa-play"></i>';
            }
        }

        // Update progress bar dan time
        audioPlayer.addEventListener('timeupdate', () => {
            const currentTime = audioPlayer.currentTime;
            const duration = audioPlayer.duration;
            const progressPercent = (currentTime / duration) * 100;

            progress.value = progressPercent;

            // Format waktu (minutes:seconds)
            currentTimeDisplay.textContent = formatTime(currentTime);
            durationTimeDisplay.textContent = formatTime(duration);
        });

        // Seek functionality
        progress.addEventListener('input', () => {
            const seekTime = (progress.value / 100) * audioPlayer.duration;
            audioPlayer.currentTime = seekTime;
        });

        // Volume control
        volumeControl.addEventListener('input', () => {
            audioPlayer.volume = volumeControl.value;
        });

        // Mute/Unmute
        muteBtn.addEventListener('click', () => {
            if (audioPlayer.muted) {
                audioPlayer.muted = false;
                muteBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
            } else {
                audioPlayer.muted = true;
                muteBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
            }
        });

        // Format time helper function
        function formatTime(time) {
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            return `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
        }
    </script>
@endsection
