@extends('layouts.app')

@section('body-inline-style', 'overflow-y: auto')

@section('content')
  <!-- Artikel Terbaru -->
  <section class="py-5">
    <div class="container">
      <h2 class="mb-4 fw-bold text-primary">Artikel Terbaru</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        @foreach ($artikelTerbaru as $artikel)
          <div class="col">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
              <div class="overflow-hidden">
                <img src="{{ asset('storage/' . $artikel->gambar_artikel) }}" class="card-img-top transition-hover"
                  alt="{{ $artikel->judul }}">
              </div>
              <div class="card-body">
                <h5 class="card-title fw-semibold text-primary">{{ $artikel->judul }}</h5>
                <p class="card-text text-muted small">{!! Str::limit(strip_tags($artikel->konten), 100) !!}</p>
                <a href="{{ route('detail.artikel', ['id' => $artikel->id]) }}"
                  class="btn btn-outline-primary btn-sm mt-2 rounded-pill">Baca Selengkapnya</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Artikel Populer -->
  <section class="py-5">
    <div class="container">
      <h2 class="mb-4 fw-bold text-primary">Artikel Populer</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        @foreach ($artikelPopuler as $artikel)
          <div class="col">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
              <div class="overflow-hidden">
                <img src="{{ asset('storage/' . $artikel->gambar_artikel) }}" class="card-img-top transition-hover"
                  alt="{{ $artikel->judul }}">
              </div>
              <div class="card-body">
                <h5 class="card-title fw-semibold text-primary">{{ $artikel->judul }}</h5>
                <p class="card-text text-muted small">{!! Str::limit(strip_tags($artikel->konten), 100) !!}</p>
                <a href="{{ route('detail.artikel', ['id' => $artikel->id]) }}"
                  class="btn btn-outline-primary btn-sm mt-2 rounded-pill">Baca Selengkapnya</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

@endsection
