<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Konsehat - Home</title>
  <link rel="icon" href="{{ asset('img/konsehat.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/app.css">
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="#">KONSEHAT</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link {{ Route::is('home') ? 'active' : '' }}"
              href="{{ route('home') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('dokter') }}">Doctors</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('artikel') }}">Artikel</a></li>
        </ul>
        <a href="{{ route('get.login') }}" class="btn btn-primary">Login</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero container">
    <div class="row align-items-center w-100">
      <!-- Left Column -->
      <div class="col-md-6">
        <h1><span style="color: #234A6B">Welcome to</span> Konsehat</h1>
        <p class="mt-3">
          Konsehat adalah platform kesehatan yang menghubungkan Anda dengan dokter terpercaya dan artikel kesehatan
          terbaru secara online.
        </p>
      </div>

      <!-- Right Column -->
      <div class="col-md-6 d-flex justify-content-center">
        <div class="image-wrapper">
          <div class="ellipse1"></div>
          <div class="ellipse2"></div>
          <img src="{{ asset('img/docter.png') }}" alt="Hero Image" class="hero-image" />
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
