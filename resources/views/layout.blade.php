<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384" crossorigin="anonymous">
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">



    <title>@yield('title')</title>
    <style>
        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .user-menu:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>

<body>
    <header class="bg-success text-white text-center py-3">
        <h2>E-Commerce</h2>
    </header>

    <nav class="bg-light py-2">
        <div class="container d-flex justify-content-between">
            <ul class="nav">
                @guest('client')
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('admin.index') }}">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('client.index') }}">Client</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('categories.index') }}">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('home') }}">Product</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('home') }}">Product</a>
                    </li>
                @endguest
            </ul>
            <ul class="nav">
                @guest('admin')
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('admin.login') }}">Admin Login</a>
                    </li>
                @else
                    <li class="nav-item user-menu">
                        <a class="nav-link text-dark" href="#">
                            <img src="{{ asset('storage/' . Auth::guard('admin')->user()->image) }}" alt="Profile Image"
                                width="30" height="30" style="border-radius: 50%;">
                            <span>{{ Auth::guard('admin')->user()->user_name }}</span>
                            <span class="arrow"></span>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('admin.edit', Auth::guard('admin')->user()->id) }}">My Profile</a></li>
                            <li><a class="dropdown-item" href="">My
                                    Orders</a></li>


                        </ul>
                    </li>
                @endguest
                @guest('client')
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('client.login') }}">Client Login</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="{{ route('cart') }}">
                            <i class="bi bi-cart"></i> Cart <span class="badge bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item user-menu">
                        <a class="nav-link text-dark" href="#">
                            <img src="{{ asset('storage/' . Auth::guard('client')->user()->image) }}" alt="Profile Image"
                                width="60" height="60" style="border-radius: 50%;">
                            <span>{{ Auth::guard('client')->user()->user_name }}</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('client.logout') }}">Logout</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('client.edit', Auth::guard('client')->user()->id) }}">My Profile</a>
                            </li>


                            <li><a class="dropdown-item" href="{{ route('orders.show') }}">
                                    My Orders</a>
                            </li>


                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <h4>@yield('title')</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qLaHFj0iSjmEpBbkTiX00qBaCbqM+z3/qlZ+qonV1zoyp3E54LgMGM9cD8/+0hb7" crossorigin="anonymous">
    </script>
</body>

</html>
