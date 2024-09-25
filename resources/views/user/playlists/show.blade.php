@extends('layouts.user')

@section('title', 'Zentify - Playlist: ' . $playlist->name)

<link rel="stylesheet" href="{{ asset('user/css/playlists/playlist-show.css') }}">
@section('content')
    <div class="container">
        <div class="container-header">
            <div class="header-one">
                @if ($playlist->image_path)
                    <img src="{{ asset('storage/' . $playlist->image_path) }}" alt="{{ $playlist->name }}"
                        class="img-thumbnail mb-4" width="200">
                @else
                    <img src="{{ asset('item/default-image.jpg') }}" alt="No Image" class="img-thumbnail mb-4"
                        width="200">
                @endif
            </div>
            <div class="header-two">
                <p class="playlist-ht">Playlist</p>
                <h1>{{ $playlist->name }}</h1>
                <div class="action">
                    <p>By: {{ Auth::user()->name }} •</p>
                    <a href="{{ route('user.playlists.edit', $playlist->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('user.playlists.destroy', $playlist->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah kamu yakin untuk menghapus playlist ini?')">Hapus</button>
                    </form>
                </div>
            </div>
        </div>



        @if ($songs->isEmpty())
            <p class="placeholder-no-song pl-12">YAH, belum ada lagu yang anda tambahkan di playlist ini nih, <a
                    href="{{ route('user.playlists.edit', $playlist->id) }}">Tambahkan Sekarang Yuk</a>.</p>
        @else
            <div class="playlist-container">
                <table class="playlist-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Artis</th>
                            <th>Album</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($songs as $song)
                            <tr onclick="playSelectedSong({{ $loop->index }})">
                                <td>{{ $loop->iteration }}</td>
                                <td class="song-title-artist">
                                    <img src="{{ $song->image_path ? asset('storage/' . $song->image_path) : asset('item/default-image.jpg') }}"
                                        alt="{{ $song->title }}" class="song-img">
                                    <div>
                                        <strong>{{ $song->title }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span>{{ $song->artist->name }}</span>
                                </td>
                                <td>{{ $song->album->title }}</td>
                                <td>
                                    <button class="play-pause-btn" id="play-pause-btn-{{ $loop->index }}"
                                        onclick="toggleCardPlayPause(event, {{ $loop->index }})">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>

    <!-- Kontrol Audio -->
    <div class="audio-control">
        <div class="audio-info">
            <img id="audio-thumbnail" src="" alt="Song Thumbnail" class="thumbnail">
            <div class="song-details">
                <h4 id="audio-title">No Song Playing</h4>
                <p id="audio-artist">Unknown Artist</p>
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
                <input type="range" id="progress" value="0" min="0" max="100" class="styled-range">
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
    <audio id="audio-player"></audio>

@endsection

@section('scripts')
    <script>
        let audioPlayer = document.getElementById('audio-player');
        let playPauseBtn = document.getElementById('play-pause-btn');
        let progressBar = document.getElementById('progress');
        let currentTimeDisplay = document.getElementById('current-time');
        let durationTimeDisplay = document.getElementById('duration-time');
        let volumeControl = document.getElementById('volume-control');
        let muteBtn = document.getElementById('mute-btn');

        let currentSongIndex = 0;
        let isPlaying = false;
        let songs = @json($songs);

        function loadSong(songIndex) {
            let song = songs[songIndex];
            audioPlayer.src = "{{ asset('storage') }}/" + song.file_path;
            document.getElementById('audio-title').textContent = song.title;
            document.getElementById('audio-artist').textContent = song.artist.name;
            document.getElementById('audio-thumbnail').src = "{{ asset('storage') }}/" + song.image_path;

            audioPlayer.onloadedmetadata = function() {
                progressBar.max = Math.floor(audioPlayer.duration);
                durationTimeDisplay.textContent = formatTime(audioPlayer.duration);
            };
        }

        function playSelectedSong(index) {
            if (currentSongIndex !== index) {
                resetCardButtons();
            }
            currentSongIndex = index;
            loadSong(currentSongIndex);
            togglePlayPause();
        }

        function togglePlayPause() {
            if (isPlaying) {
                audioPlayer.pause();
                updatePlayPauseButtons('play');
            } else {
                audioPlayer.play();
                updatePlayPauseButtons('pause');
            }
            isPlaying = !isPlaying;
        }

        function updatePlayPauseButtons(action) {
            if (action === 'play') {
                playPauseBtn.querySelector('i').classList.remove('fa-pause');
                playPauseBtn.querySelector('i').classList.add('fa-play');
            } else {
                playPauseBtn.querySelector('i').classList.remove('fa-play');
                playPauseBtn.querySelector('i').classList.add('fa-pause');
            }

            resetCardButtons();

            let cardButton = document.getElementById('play-pause-btn-' + currentSongIndex);
            if (action === 'play') {
                cardButton.querySelector('i').classList.remove('fa-pause');
                cardButton.querySelector('i').classList.add('fa-play');
            } else {
                cardButton.querySelector('i').classList.remove('fa-play');
                cardButton.querySelector('i').classList.add('fa-pause');
            }
        }

        function resetCardButtons() {
            document.querySelectorAll('.play-pause-btn i').forEach(function(icon) {
                icon.classList.remove('fa-pause');
                icon.classList.add('fa-play');
            });
        }

        function toggleCardPlayPause(event, index) {
            event.stopPropagation();
            if (currentSongIndex !== index) {
                resetCardButtons();
                currentSongIndex = index;
                loadSong(currentSongIndex);
            }
            togglePlayPause();
        }

        audioPlayer.addEventListener('timeupdate', function() {
            progressBar.value = Math.floor(audioPlayer.currentTime);
            currentTimeDisplay.textContent = formatTime(audioPlayer.currentTime);
        });

        progressBar.addEventListener('input', function() {
            audioPlayer.currentTime = progressBar.value;
        });

        volumeControl.addEventListener('input', function() {
            audioPlayer.volume = volumeControl.value;
        });

        muteBtn.addEventListener('click', function() {
            if (audioPlayer.muted) {
                audioPlayer.muted = false;
                muteBtn.querySelector('i').classList.remove('fa-volume-mute');
                muteBtn.querySelector('i').classList.add('fa-volume-up');
            } else {
                audioPlayer.muted = true;
                muteBtn.querySelector('i').classList.remove('fa-volume-up');
                muteBtn.querySelector('i').classList.add('fa-volume-mute');
            }
        });

        function formatTime(seconds) {
            let minutes = Math.floor(seconds / 60);
            let secs = Math.floor(seconds % 60);
            if (secs < 10) secs = '0' + secs;
            return minutes + ":" + secs;
        }

        audioPlayer.onended = function() {
            resetCardButtons();
            currentSongIndex++;
            if (currentSongIndex >= songs.length) {
                currentSongIndex = 0;
            }
            loadSong(currentSongIndex);
            audioPlayer.play();
            updatePlayPauseButtons('pause');
        };

        document.getElementById('prev-btn').addEventListener('click', function() {
            resetCardButtons();
            currentSongIndex--;
            if (currentSongIndex < 0) {
                currentSongIndex = songs.length - 1;
            }
            loadSong(currentSongIndex);
            audioPlayer.play();
            updatePlayPauseButtons('pause');
        });

        document.getElementById('next-btn').addEventListener('click', function() {
            resetCardButtons();
            currentSongIndex++;
            if (currentSongIndex >= songs.length) {
                currentSongIndex = 0;
            }
            loadSong(currentSongIndex);
            audioPlayer.play();
            updatePlayPauseButtons('pause');
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (songs.length > 0) {
                loadSong(0);
            }
        });
    </script>
@endsection
