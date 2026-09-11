<style>
  .navbar-gold-theme {
    background: linear-gradient(135deg, #1a1a1a 0%, #2b2314 100%) !important;
    border-bottom: 2px solid #b8860b;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  }

  .text-gold {
    color: #d4af37 !important;
  }

  .nav-link-gold {
    color: #d1d5db !important;
    font-weight: 500;
    transition: all 0.25s ease;
    padding: 0.5rem 0.8rem !important;
    border-radius: 0.375rem;
  }

  .nav-link-gold:hover {
    color: #fef08a !important;
    background-color: rgba(212, 175, 55, 0.12);
  }

  .nav-link-gold.active {
    color: #ffffff !important;
    background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%) !important;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(184, 134, 11, 0.3);
  }

  .btn-outline-gold {
    color: #d4af37 !important;
    border: 1px solid #d4af37 !important;
    background: transparent;
    transition: all 0.3s ease;
  }

  .btn-outline-gold:hover {
    background: linear-gradient(135deg, #d4af37 0%, #b8860b 100%) !important;
    color: #ffffff !important;
    border-color: transparent !important;
    box-shadow: 0 3px 10px rgba(184, 134, 11, 0.3);
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-gold-theme sticky-top py-2">
  <div class="container">
    <a class="navbar-brand fw-bold text-gold fs-4 d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
      POS
    </a>

    <button
      class="navbar-toggler border-0"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1 ms-lg-3">
        <li class="nav-item">
          <a class="nav-link nav-link-gold {{ Request::is('dashboard') ? 'active' : '' }}"
            href="{{ route('dashboard') }}">
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
          <a class="nav-link nav-link-gold {{ Request::is('jenis*') ? 'active' : '' }}"
            href="{{ route('jenis.index') }}">
            Jenis
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link nav-link-gold {{ Request::is('produk*') ? 'active' : '' }}"
            href="{{ route('produk.index') }}">
            Produk
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link nav-link-gold {{ Request::is('penjualan*') ? 'active' : '' }}"
            href="{{ route('penjualan.index') }}">
            Penjualan
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link nav-link-gold {{ Request::is('tentang*') ? 'active' : '' }}"
            href="{{ route('tentang.index') }}">
            Tentang
          </a>
        </li>
      </ul>

      <div class="d-flex align-items-center gap-3">
        <span class="text-gold fw-semibold">
          {{ auth()->user()->name }}
        </span>

        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button class="btn btn-outline-gold btn-sm px-3 rounded-2 fw-bold">
            Logout
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>