<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title }}</title>
  <link rel="icon" href="{{ asset('img/konsehat.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  @yield('customCSS')
</head>

<body style="@yield('body-inline-style'); background-color: #ecf6ff;">


  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: white !important">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="#">KONSEHAT</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav mx-auto">

          @if (Auth::user())
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}"
                href="{{ route('user.home') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('dokter', 'dokter.list') ? 'active' : '' }}"
                href="{{ route('dokter') }}">Doctors</a></li>
            <li class="nav-item"><a
                class="nav-link {{ request()->routeIs('artikel', 'detail.artikel') ? 'active' : '' }}"
                href="{{ route('artikel') }}">Artikel</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('riwayat') ? 'active' : '' }}"
                href="{{ route('riwayat') }}">Riwayat</a></li>
          @else
            <li class="nav-item"><a class="nav-link {{ Route::is('home') ? 'active' : '' }}"
                href="{{ route('home') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link {{ Route::is('dokter') ? 'active' : '' }}"
                href="{{ route('dokter') }}">Doctors</a></li>
            <li class="nav-item"><a class="nav-link {{ Route::is('artikel') ? 'active' : '' }}"
                href="{{ route('artikel') }}">Artikel</a></li>
          @endif



        </ul>

        <!-- Dropdown User Profile -->
        <div class="dropdown">
          @if (Auth::user())
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown"
              data-bs-toggle="dropdown" aria-expanded="false">
              <img
                src="{{ Auth::user()->userDetail?->foto_user
                    ? asset('storage/img/foto/' . Auth::user()->userDetail->foto_user)
                    : asset('img/1.png') }}"
                alt="User" width="40" height="40" class="rounded-circle me-2">

              <span class="d-none d-sm-inline">Halo,
                {{ Auth::user()->userDetail?->nama_user ?? Auth::user()->name }}</span>
            </a>
          @else
            <a href="{{ route('get.login') }}" class="btn btn-primary">Login</a>
          @endif

          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="{{ route('profil.user') }}">Profil Saya</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>

            <li>
              <a class="dropdown-item text-danger" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
              </a>
            </li>

          </ul>
        </div>
      </div>
    </div>
  </nav>

  @if (session('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @yield('content')

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var successAlert = document.getElementById('success-alert');
      if (successAlert) {
        setTimeout(function() {
          successAlert.style.display = 'none';
        }, 3000);
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @yield('customJS')
</body>

</html>
