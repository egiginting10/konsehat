@extends('layouts.app')

@section('content')
  <section class="py-5">
    <section class="py-5">
      <div class="container">
        <!-- Judul Riwayat -->
        <div class="mb-4 pb-2 border-bottom" style="max-width: 90%; margin: 0 auto;">
          <h2 class="fw-bold">Riwayat Saya</h2>
        </div>

        <!-- Konten Tengah -->
        <div class="text-center mt-5">
          <h4 class="fw-bold mb-3" style="font-size: 3rem">Belum Pernah konsultasi</h4>
          <p class="mb-4" style="font-size: 1.8rem">
            Ayo buat janji konsultasi dengan Dokter<br />
            proses gampang, cepat, dan tepat
          </p>
          <a href="{{ route('dokter') }}" class="btn btn-primary px-4 py-2">Cari Dokter</a>
        </div>
      </div>
    </section>

  </section>
@endsection
