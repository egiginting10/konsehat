@extends('layouts.app')

@section('body-inline-style', 'overflow-y: auto !important')

@section('content')
  <section class="py-5">
    <section class="py-5">
      <div class="container">

        <!-- Tombol Search -->
        <div class="text-center mb-5">
          <div class="mx-auto" style="max-width: 500px;">
            <form action="{{ route('dokter') }}" method="GET" class="d-flex">
              <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2"
                placeholder="Cari dokter berdasarkan spesialisasi...">
              <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
          </div>
        </div>

        <!-- Judul Spesialisasi -->
        <div class="mb-4 pb-2 border-bottom" style="max-width: 100%; margin: 0 auto;">
          <h3 class="fw-bold">Pilih Sesuai Spesialisasi</h3>
        </div>
        @if ($spesialisasiDokter->isEmpty())
          <div class="col-12">
            <div class="alert alert-warning text-center">
              {{ $message ?? 'Belum ada Daftar Dokter Spesialis.' }}
            </div>
          </div>
        @else
          <!-- Card Spesialisasi -->
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-3">
            <!-- Card 1 -->
            @foreach ($spesialisasiDokter as $spesialisasi)
              <div class="col">
                <a href="{{ route('dokter.list', ['spesialisasi' => $spesialisasi]) }}">
                  <div class="card text-white shadow"
                    style="height: 200px; background-image: url('{{ asset('img/dokterexp.jpg') }}'); background-size: contain; background-repeat: no-repeat; background-position: center;">
                    <div class="card-img-overlay d-flex align-items-end p-3"
                      style="background: rgba(0,0,0,0.4); border-radius: 0.5rem;">
                      <h5 class="card-title m-0">{{ ucwords($spesialisasi) }}</h5>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
        @endif


      </div>
      </div>
    </section>
  </section>
@endsection
