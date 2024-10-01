@extends('layouts.app')

@section('title', 'Zentify | About')


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Rubik+Mono+One&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('user/css/about.css') }}">
@section('content')
    <header>
        <a href="{{ url('songs') }}">
            <img src="{{ asset('item/logo.png') }}" alt="logo Zentify" class="logo">
        </a>

        <form action="{{ route('user.songs.index') }}" method="GET" class="search-bar">
            <button class="btn btn-primary" type="submit">
                <img src="{{ asset('item/search-icon.png') }}" alt="">
            </button>
            <input type="text" name="search" placeholder="Cari lagu atau artis..."
                value="{{ request()->get('search') }}" class="form-search">
        </form>

        @if (Route::has('login'))
            <nav>
                @auth
                    <a href="{{ url('/songs') }}">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        Masuk
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="register">
                            Daftar
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <section class="container-about">
        <img src="{{ asset('item/parallax/background.jpg') }}" alt="Parallax Background" id="bg">
        <div id="clouds_1">
            <img src="{{ asset('item/parallax/3d-molecul.gif') }}" alt="Cloud 1">
        </div>
        <div id="clouds_2">
            <img src="{{ asset('item/parallax/3d-molecul.gif') }}" alt="Cloud 2">
        </div>
        <h2 id="text">Zentify</h2>
        <img src="{{ asset('item/parallax/dj-mele.png') }}" alt="Man" id="man">
        <img src="{{ asset('item/parallax/tebing-left.png') }}" alt="Tebing Left" id="mountain_left">
        <img src="{{ asset('item/parallax/tebing-right.png') }}" alt="Tebing Right" id="mountain_right">
    </section>

    <section class="container-main-sh">
        <div class="container-sh">
            <section class="warpper-404">
                <div class="container-main-h-sh">
                    <h1 class="heading-sh" data-text="Temukan Suara Hatimu dalam Setiap Nada">Temukan Suara Hatimu dalam
                        Setiap Nada</h1>
                </div>

                {{-- <h1 class="heading-sh">Temukan Suara Hatimu dalam Setiap Nada</h1> --}}

                <div class="card" id="card-1">
                    <img src="{{ asset('item/parallax/infinite.gif') }}" alt="No Image" class="img-sh">
                </div>
                <div class="card" id="card-2">
                    <img src="{{ asset('item/parallax/infinite.gif') }}" alt="No Image" class="img-sh">
                </div>
                <div class="card" id="card-3">
                    <img src="{{ asset('item/parallax/infinite.gif') }}" alt="No Image" class="img-sh">
                </div>
                <div class="card" id="card-4">
                    <img src="{{ asset('item/parallax/infinite.gif') }}" alt="No Image" class="img-sh">
                </div>
            </section>
            <section class="outro">
                <div class="content-about">
                    <p>Selamat datang di Zentify – tempat di mana musik bertemu dengan inovasi! Zentify adalah destinasi
                        utama
                        untuk
                        menemukan, mendengarkan, dan menikmati lagu favoritmu dalam satu platform. Apapun suasana hati kamu,
                        dari ingin
                        bersantai dengan alunan musik yang tenang hingga membangkitkan semangat dengan lagu-lagu penuh
                        energi,
                        Zentify
                        punya semuanya.
                        <br><br>
                        Kami percaya bahwa musik bukan hanya sekadar suara – ini adalah pengalaman. Itulah sebabnya Zentify
                        dirancang
                        untuk meningkatkan perjalanan musikmu dengan menawarkan playlist pilihan, rekomendasi yang
                        dipersonalisasi, dan
                        antarmuka yang mulus sehingga setiap sesi mendengarkan terasa istimewa. Jelajahi perpustakaan lagu
                        yang
                        luas
                        dari berbagai genre, temukan musik yang kamu cintai, dan eksplorasi lagu-lagu baru yang akan
                        membuatmu
                        terus
                        kembali.
                        <br><br>
                        Di Zentify, kami memberikan kebebasan untuk mengekspresikan dirimu melalui musik, baik dengan
                        membuat
                        playlist
                        pribadi atau menemukan lagu-lagu tersembunyi yang menarik. Bergabunglah dengan komunitas musik kami
                        yang
                        penuh
                        semangat, dan biarkan Zentify menjadi soundtrack hidupmu!
                    </p>
                    <div class="spiral">
                        <img src="{{ asset('item/glow-n-spiral.gif') }}" alt="spiral">
                    </div>
                </div>
            </section>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>

    <script>
        gsap.to("#bg", {
            scrollTrigger: {
                scrub: 1,
            },
            scale: 3,
        })

        gsap.to("#man", {
            scrollTrigger: {
                scrub: 1,
            },
            scale: .3,
        })

        gsap.to("#mountain_left", {
            scrollTrigger: {
                scrub: 1,
            },
            x: -500,
        })

        gsap.to("#mountain_right", {
            scrollTrigger: {
                scrub: 1,
            },
            x: 500,
        })

        gsap.to("#clouds_1", {
            scrollTrigger: {
                scrub: 1,
            },
            x: -700,
            y: -100,
        })

        gsap.to("#clouds_2", {
            scrollTrigger: {
                scrub: 1,
            },
            y: 100,
            x: 400,
        })


        gsap.registerPlugin(ScrollTrigger);

        document.addEventListener("DOMContentLoaded", function() {
            const cards = [{
                    id: "#card-1",
                    endTranslateX: -2000,
                    rotate: 45,
                },
                {
                    id: "#card-2",
                    endTranslateX: -1000,
                    rotate: 30,
                },
                {
                    id: "#card-3",
                    endTranslateX: -2000,
                    rotate: 45,
                },
                {
                    id: "#card-4",
                    endTranslateX: -1500,
                    rotate: -30,
                },
            ];

            ScrollTrigger.create({
                trigger: ".warpper-404",
                start: "top top",
                end: "+=900vh",
                scrub: 1,
                pin: true,
                onUpdate: (self) => {
                    gsap.to(".warpper-404", {
                        x: `${-350 * self.progress}vw`,
                        duration: 0.5,
                        ease: "power3.out",
                    });
                },
            });

            cards.forEach((card) => {
                ScrollTrigger.create({
                    trigger: card.id,
                    start: "top top",
                    end: "+=1200vh",
                    scrub: 1,
                    pin: true,
                    onUpdate: (self) => {
                        gsap.to(card.id, {
                            x: `${card.endTranslateX * self.progress}px`,
                            rotate: `${card.rotate * self.progress * 2}`,
                            duration: 0.5,
                            ease: "power3.out",
                        });
                    },
                });
            });
        });
    </script>
@endsection
