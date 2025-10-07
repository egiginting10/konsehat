@extends('layouts.app')

@section('body-inline-style', 'overflow-y: auto !important')

@section('content')
  <section class="py-5">
    <div class="container" style="max-width: 1200px;">
      <div class="row align-items-center mb-4">
        <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
          <img src="{{ asset('storage/' . $artikel->gambar_artikel) }}" alt="Tips Musim Pancaroba"
            class="img-fluid rounded shadow-sm" style="height: 120px;">
        </div>
        <div class="col-md-10">
          <h1 class="fw-bold mb-1">{{ $artikel->judul }}</h1>
          <p class="text-muted mb-0">Ditulis oleh <strong>{{ $artikel->penulis }}</strong> |
            {{ \Carbon\Carbon::parse($artikel->created_at)->format('d F Y') }}</p>
        </div>
      </div>

      <div class="fs-5 text-justify" style="line-height: 1.8;">
        {!! $artikel->konten !!}
      </div>

      <div class="mt-5 text-end">
        <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
          <i class="fas fa-arrow-left me-2"></i>Kembali ke Artikel
        </a>
      </div>

      <div class="mt-5">
        <h4 class="fw-bold mb-4">Artikel Lainnya</h4>
        <div class="row g-4">
          @foreach ($artikelLainnya as $item)
            <div class="col-md-4">
              <div class="card h-100 shadow-sm border-0">
                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->judul }}">
                <div class="card-body">
                  <h5 class="card-title">{{ $item->judul }}</h5>
                  <p class="card-text text-muted">{{ Str::limit(strip_tags($item->isi), 80) }}</p>
                  <a href="{{ route('detail.artikel', $item->id) }}" class="btn btn-sm btn-outline-primary">Baca
                    Selengkapnya</a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </section>
@endsection
