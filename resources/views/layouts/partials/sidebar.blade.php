<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zentify</title>
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: var(--hitam);
            color: var(--putih);
        }

        /* Color Variables */
        :root {
            --biru: #0060E0;
            --hitam: #01010a;
            --abu: #1b1b1b;
            --putih: #ebebeb;
            --abu-muda: #858585;
        }

        /* Sidebar Styles */
        .sb-sidenav {
            width: 220px;
            background-color: var(--abu);
            position: fixed;
            height: 100%;
            overflow-y: auto;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.5);
            transition: all 0.3s;
        }


        .sb-sidenav-menu {
            padding: 20px;
        }

        .sb-sidenav-menu-heading {
            font-size: 0.85rem;
            text-transform: uppercase;
            margin: 0;
            color: var(--abu-muda);
            letter-spacing: 1px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px;
            margin-bottom: 8px;
            color: var(--putih);
            text-decoration: none;
            font-size: 1rem;
            border-radius: 6px;
            transition: background-color 0.3s, padding-left 0.3s;
        }

        .nav-link:hover {
            background-color: var(--biru);
            padding-left: 20px;
        }

        .sb-nav-link-icon {
            margin-right: 12px;
            color: var(--putih);
            font-size: 1.3rem;
            transition: transform 0.3s;
        }

        .nav-link:hover .sb-nav-link-icon {
            transform: rotate(360deg);
        }


        /* Smooth Hover Effects */
        .nav-link::before {
            content: "";
            position: absolute;
            width: 6px;
            height: 100%;
            background-color: var(--biru);
            top: 0;
            left: 0;
            border-radius: 0 4px 4px 0;
            transform: scaleY(0);
            transition: transform 0.3s;
        }

        .nav-link:hover::before {
            transform: scaleY(1);
        }

    </style>
</head>
<body>
    <nav class="sb-sidenav accordion" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ url('admin/dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link" href="{{ url('admin/songs')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-music"></i></div>
                    Daftar Lagu
                </a>
                <a class="nav-link" href="{{ url('admin/artists')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Daftar Artist
                </a>
                <a class="nav-link" href="{{ url('admin/albums')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-record-vinyl"></i></div>
                    Daftar Album
                </a>
                <a class="nav-link" href="{{ url('admin/genres')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Daftar Genre
                </a>
                <a class="nav-link" href="{{ url('admin/users')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    User
                </a>
            </div>
        </div>
    </nav>
</body>
</html>
