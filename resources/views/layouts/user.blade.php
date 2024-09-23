<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    {{-- fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik+Mono+One&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" href="{{ asset('item/logo-ico.png') }}" type="image/png">
    <style>
        :root {
            --biru: rgb(0, 96, 224);
            --hitam: #000005;
            --abu: #1b1b1b;
            --putih: #f8f8f8;
            --abu-muda: #858585;
            --abu-lebih-muda: #cacaca;
            --biru-tua: #00459f;
        }

        body {
            background-color: var(--hitam);
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: rgba(0, 0, 5, .9);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            gap: 30px;
            position: fixed;
            right: 0;
            left: 0;
            top: 0;
            z-index: 99;
        }

        header .logo {
            width: 100px;
            height: 60px;
            transition: .3s;
            top: -5;
            position: relative;
        }

        header .logo:hover {
            transform: scale(1.07);
        }

        header .dropdown {
            display: flex;
            justify-content: end;
        }

        header .dropdown {
            position: relative;
            top: -8;
            display: inline-block;
        }

        header .dropdown button {
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        header .dropdown button:hover {
            color: #0048b3;
            /* Darker shade when hovered */
        }

        /* Dropdown content (hidden by default) */
        header .dropdown-content {
            top: 50;
            right: 20;
            display: none;
            position: absolute;
            background: var(--putih);
            min-width: 160px;
            box-shadow: 0 0 1rem var(--hitam);
            z-index: 99999;
            border-radius: 4px;
        }

        /* Dropdown links */
        header .dropdown-content a {
            color: var(--hitam);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        header .dropdown-content a:hover {
            background-color: var(--abu-lebih-muda);
        }

        /* Show the dropdown menu on button click */
        header .dropdown.show .dropdown-content {
            display: block;
        }
    </style>
</head>

<body>
    <div class="main-content">
        {{-- @include('layouts.navigation') --}}
        <header>
            <div class="item-one">
                <a href="{{ url('songs') }}">
                    <img src="{{ asset('item/logo.png') }}" alt="logo Zentify" class="logo">
                </a>
            </div>

            <div class="dropdown">
                <button onclick="toggleDropdown()">Hi' {{ Auth::user()->name }} &#x25BC;</button>
                <div class="dropdown-content">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                  this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                    <a href="{{ route('profile.edit') }}">Profile</a>
                </div>
            </div>
        </header>


        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <script>
        // Function to toggle dropdown menu
        function toggleDropdown() {
            const dropdown = document.querySelector('.dropdown');
            dropdown.classList.toggle('show');
        }

        // Close the dropdown if clicked outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown button')) {
                const dropdown = document.querySelector('.dropdown');
                if (dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.2/dist/cdn.min.js"></script>

    @yield('scripts')
</body>

</html>
