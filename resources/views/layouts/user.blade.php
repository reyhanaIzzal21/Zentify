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

    <link rel="stylesheet" href="{{ asset('user/css/user_style.css') }}">
</head>

<body>
    <div class="main-content">
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
