<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zentify Dashboard</title>
    <style>
        /* General Navbar Styles */
        .navbar {
            background-color: rgba(27, 27, 27, 0.8);
            backdrop-filter: blur(10px);
            padding: 10px 20px;
            width: 100%;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: background-color 0.3s;
        }

        /* Brand Logo */
        .navbar-brand {
            padding: 0;
            font-size: 1.5rem;
            color: #ebebeb;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
        }

        .navbar-brand:hover {
            color: #0060E0;
        }

        /* Hamburger Button */
        .btn-hamburger {
            font-size: 1.5rem;
            color: #ebebeb;
            background: none;
            border: none;
            margin-right: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: color 0.3s;
        }

        .btn-hamburger:hover {
            color: #0060E0;
        }

        .btn-hamburger:focus {
            outline: none;
        }

        /* Navbar Right Side (User Profile and Notifications) */
        .navbar-right {
            display: flex;
            align-items: center;
        }

        .navbar-right .nav-item {
            margin-left: 20px;
            position: relative;
        }

        .navbar-right .nav-link {
            color: #ebebeb;
            font-size: 1.25rem;
            text-decoration: none;
            transition: color 0.3s;
        }

        .navbar-right .nav-link:hover {
            color: #0060E0;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            background-color: #1b1b1b;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: absolute;
            top: 60px;
            right: 0;
            display: none;
            min-width: 150px;
            border-radius: 8px;
            z-index: 1500;
            transition: opacity 0.3s ease, transform 0.3s ease;
            opacity: 0;
            transform: translateY(-10px);
        }

        .dropdown-item {
            color: #ebebeb;
            padding: 10px;
            text-decoration: none;
            display: block;
            transition: 0.3s;
        }

        .dropdown-item:hover {
            transform: scale(1.03);
        }

        /* Show Dropdown on Click */
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        li{
            list-style: none;
        }

        /* Responsive Styles for Mobile */
        @media (max-width: 768px) {
            .navbar {
                padding: 5px 10px;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .btn-hamburger {
                margin-right: 10px;
            }

            .navbar-right {
                display: none;
            }

            .navbar-right.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 60px;
                right: 10px;
                background-color: #1b1b1b;
                padding: 10px;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar sb-topnav navbar-expand navbar-dark">
        <!-- Sidebar Toggle Button -->
        <button class="btn-hamburger btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>

        <!-- Brand Logo -->
        <a class="navbar-brand ps-3" href="{{ url('admin/dashboard') }}">Zentify</a>

        <!-- Right Side Elements -->
        <div class="navbar-right" id="navbarRight">
            <!-- User Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
        </div>
    </nav>
</body>
</html>
