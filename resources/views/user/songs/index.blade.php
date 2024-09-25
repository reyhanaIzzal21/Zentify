@extends('layouts.user')

@section('title', 'Zentify | Home')

<link rel="stylesheet" href="{{ asset('user/css/song-index.css') }}">

@section('content')
    <form action="{{ route('user.songs.index') }}" method="GET" class="search-bar">
        <button class="btn btn-primary" type="submit">
            <img src="{{ asset('item/search-icon.png') }}" alt="">
        </button>
        <input type="text" name="search" placeholder="Cari lagu atau artis..." value="{{ request()->get('search') }}"
            class="form-search">
    </form>


    <section class="container-ps">
        <!-- Sidebar Playlist -->
        <div class="sidebar">
            <div class="item one">
                <h3><a href="{{ url('playlists') }}"><i class="fa-solid fa-headphones-simple"></i>Playlist</a></h3>
                <div class="btn-cp-np">
                    <a href="{{ route('user.playlists.create') }}" class="btn-cp btn-primary mt-3"><i
                            class="fa-solid fa-plus"></i>
                        <p>Buat Playlist</p>
                    </a>
                    <a href="{{ url('playlists') }}" class="btn-next-playlist"><i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
            <ul class="playlist-list">
                @foreach ($playlists as $playlist)
                    <li class="playlist-item">
                        <a href="{{ route('user.playlists.show', $playlist->id) }}">
                            @if ($playlist->image_path)
                                <img src="{{ asset('storage/' . $playlist->image_path) }}" alt="{{ $playlist->name }}">
                            @else
                                <img src="{{ asset('item/default-image.jpg') }}" alt="Default Playlist Image">
                            @endif
                            <p>Playlist . {{ $playlist->name }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>



        <div class="songs-container">
            @if ($songs->isEmpty())
                <p class="no-song">YAH, Tidak ada lagu yang di temukan nih.</p>
            @else
                @foreach ($songs as $song)
                    <div class="song-card" onclick="playSelectedSong({{ $loop->index }})">
                        <div class="song-image">
                            <a href="{{ route('user.songs.show', $song->id) }}" class="text-blue-500">
                                @if ($song->image_path)
                                    <img src="{{ asset('storage/' . $song->image_path) }}" alt="{{ $song->title }}">
                                @else
                                    <img src="{{ asset('item/default-image.jpg') }}" alt="No Image">
                                @endif
                            </a>
                            <button class="play-pause-btn" id="play-pause-btn-{{ $loop->index }}"
                                onclick="toggleCardPlayPause(event, {{ $loop->index }})">
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                        <div class="song-details">
                            <a href="{{ route('user.songs.show', $song->id) }}" class="text-blue-500">
                                <h3>{{ $song->title }}</h3>
                            </a>
                            <p>By {{ Str::limit($song->artist->name, 25) }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <!-- Kontrol Audio -->
    <div class="audio-control">
        <div class="audio-info">
            {{-- <a href="{{ route('user.songs.show', $song->id) }}" class="text-blue-500"> --}}
            <img id="audio-thumbnail" src="" alt="Song Thumbnail" class="thumbnail">
            {{-- </a> --}}
            <div class="song-details">
                {{-- <a href="{{ route('user.songs.show', $song->id) }}" class="text-blue-500"> --}}
                <h4 id="audio-title">No Song Playing</h4>
                {{-- </a> --}}
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
        let isSeeking = false; // Variabel isSeeking ditambahkan
        let songs = @json($songs);

        // Muat lagu yang dipilih berdasarkan indeks
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
            // Reset semua tombol card audio ke status play
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

        // Event listener untuk progress bar
        audioPlayer.addEventListener('timeupdate', function() {
            if (!isSeeking) { // Update hanya jika tidak sedang seek
                progressBar.value = Math.floor(audioPlayer.currentTime);
                currentTimeDisplay.textContent = formatTime(audioPlayer.currentTime);
            }
        });

        // Menandakan user sedang menggeser progress bar
        progressBar.addEventListener('mousedown', function() {
            isSeeking = true; // Menandakan sedang seek
        });

        // Update waktu saat sedang menggeser progress bar
        progressBar.addEventListener('input', function() {
            let seekTime = progressBar.value;
            currentTimeDisplay.textContent = formatTime(seekTime); // Update tampilan waktu saat di-drag
        });

        // Update waktu audio player saat progress bar dilepas
        progressBar.addEventListener('mouseup', function() {
            isSeeking = false; // Selesai seek
            audioPlayer.currentTime = progressBar.value; // Update waktu audio player
        });


        // Kontrol volume
        volumeControl.addEventListener('input', function() {
            audioPlayer.volume = volumeControl.value;
        });

        // Mute / Unmute audio
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
            // Reset tombol card sebelumnya
            resetCardButtons();

            // Pindah ke lagu selanjutnya
            currentSongIndex++;
            if (currentSongIndex >= songs.length) {
                currentSongIndex = 0; // Jika sudah sampai akhir playlist, kembali ke awal
            }

            loadSong(currentSongIndex); // Load lagu berikutnya
            audioPlayer.play(); // Langsung putar lagu berikutnya
            updatePlayPauseButtons('pause'); // Update tampilan tombol
        };

        // Tombol untuk lagu sebelumnya
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

        // Tombol untuk lagu selanjutnya
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

        // Muat lagu pertama saat halaman dimuat
        loadSong(currentSongIndex);
    </script>

@endsection
@endsection
