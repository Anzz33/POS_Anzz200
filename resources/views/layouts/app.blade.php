<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS System')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }

        .sidebar-wrapper {
            width: 240px;
            height: 100vh;
            background-color: #1a1814;
            flex-shrink: 0;
        }

        .sidebar-brand {
            font-size: 1.8rem;
            font-weight: 800;
            color: #d4af37;
            text-decoration: none;
            letter-spacing: 1px;
            display: block;
            padding: 1.25rem 1.5rem;
        }

        .sidebar-menu .nav-link {
            color: #cccccc;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            margin: 0.2rem 0.8rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .sidebar-menu .nav-link:hover {
            color: #ffffff;
            background-color: rgba(212, 175, 55, 0.15);
        }

        .sidebar-menu .nav-link.active {
            color: #1a1814 !important;
            background-color: #d4af37 !important;
            font-weight: 700;
        }

        .btn-gold-outline {
            border: 1px solid #d4af37;
            color: #d4af37;
            font-weight: 600;
        }

        .btn-gold-outline:hover {
            background-color: #d4af37;
            color: #1a1814;
        }

        .main-content-wrapper {
            height: 100vh;
            overflow-y: auto;
        }

        .avatar-sidebar {
            width: 36px;
            height: 36px;
            object-fit: cover;
            border: 2px solid #d4af37;
        }
    </style>
</head>
<body>

    <div class="d-flex vh-100 overflow-hidden">
        <!-- SIDEBAR KIRI -->
        <aside class="sidebar-wrapper d-flex flex-column justify-content-between">
            <div>
                <a href="{{ route('dashboard') }}" class="sidebar-brand">
                    POS
                </a>
                
                <ul class="nav nav-pills flex-column sidebar-menu mt-2">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" 
                           class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
                            Dashboard
                        </a>
                    </li>

                    @if(auth()->user()->role->name == 'admin')
                     <li class="nav-item">
                        <a class="nav-link nav-link-gold {{ Request::is('users*') ? 'active' : '' }}"
                          href="{{ route('users.index') }}">
                            Users
                      </a>
                    </li>
                     @endif

                    <li class="nav-item">
                        <a href="{{ route('jenis.index') }}" 
                           class="nav-link {{ request()->is('jenis*') ? 'active' : '' }}">
                            Jenis
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('produk.index') }}" 
                           class="nav-link {{ request()->is('produk*') ? 'active' : '' }}">
                            Produk
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('penjualan.index') }}" 
                           class="nav-link {{ request()->is('penjualan*') ? 'active' : '' }}">
                            Penjualan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('tentang.index') }}" 
                           class="nav-link {{ request()->is('tentang*') ? 'active' : '' }}">
                            Tentang
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Profil User & Logout -->
            <div class="p-3 border-top border-secondary text-center">
                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                    @if(Auth::user() && Auth::user()->foto)
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="rounded-circle avatar-sidebar" alt="Avatar">
                    @endif
                    <span class="text-warning fw-semibold text-truncate" style="max-width: 140px;">
                        {{ Auth::user()->name ?? 'User' }}
                    </span>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-gold-outline btn-sm w-100 rounded-2">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-grow-1 main-content-wrapper">
            <main class="p-4">
                <!-- Alert Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>