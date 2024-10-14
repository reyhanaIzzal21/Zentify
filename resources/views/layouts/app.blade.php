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

    <link rel="stylesheet" href="{{ asset('user/css/welcome-style.css') }}">
    <link rel="icon" href="{{ asset('item/logo-ico.png') }}" type="image/png">
</head>

<body>
    <div class="main-content">

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.2/dist/cdn.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>
