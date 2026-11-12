<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CloudCakes - Bakery POS</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background-color: #4a3b5c; /* Dusty Purple */
        }
        .navbar-custom .navbar-brand, 
        .navbar-custom .nav-link, 
        .navbar-custom .dropdown-toggle {
            color: #ffffff !important;
        }
        .navbar-custom .nav-link:hover {
            color: #dcd0e8 !important;
        }
        .btn-primary {
            background-color: #7b5294;
            border-color: #7b5294;
        }
        .btn-primary:hover {
            background-color: #633f78;
            border-color: #633f78;
        }
    </style>
</head>
<body>

    <!-- Navbar Dusty Purple -->
    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('dashboard') }}">
                🎂 CloudCakes
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
    @auth
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        </li>

        @if(Auth::user()->role === 'admin')
            <!-- Admin: Kelola Produk & Kategori, Pantau Pelanggan & Riwayat Transaksi -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories.index') }}">Kategori Roti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.index') }}">Katalog Roti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('customers.index') }}">Data Pelanggan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('transactions.index') }}">Riwayat Transaksi</a>
            </li>
        @else
            <!-- Kasir: Input Pelanggan & Melayani Transaksi Baru -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('customers.index') }}">Input Pelanggan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('transactions.create') }}">Transaksi Baru</a>
            </li>
        @endif
    @endauth
</ul>

                <!-- Right Side (User Profile & Logout) -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Keluar / Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main>
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>