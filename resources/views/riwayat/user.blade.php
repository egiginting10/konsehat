@extends('layouts.app')

@section('content')
  <section class="py-5">
    <section class="py-5">
      <div class="container">
        <div class="text-center mb-5">
          <div class="mx-auto" style="max-width: 500px;">
            <form action="{{ route('riwayat') }}" method="GET" class="d-flex">
              <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2"
                placeholder="Cari riwayat...">
              <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
          </div>
        </div>
        <!-- Judul Riwayat -->
        <div class="mb-4 pb-2 border-bottom" style="max-width: 100%; margin: 0 auto;">
          <h2 class="fw-bold">Riwayat Saya</h2>
        </div>

        <div class="row g-4">
          @if ($riwayats->isEmpty())
            <div class="col-12">
              <div class="alert alert-warning text-center">
                {{ $message ?? 'Belum ada riwayat konsultasi.' }}
              </div>
            </div>
          @else
            @foreach ($riwayats as $riwayat)
              <div class="col-12">
                <div class="card shadow-sm p-3 d-flex flex-row align-items-start justify-content-between">
                  <div class="d-flex">
                    <img
                      src="{{ $riwayat->foto_dokter ? asset('storage/' . $riwayat->foto_dokter) : asset('img/1.png') }}"
                      alt="Foto Dokter" width="80" height="80" class="rounded-circle me-3 object-fit-cover"
                      style="object-fit: cover;">

                    <div>
                      <h6 class="fw-bold mb-1">{{ $riwayat->nama_dokter }}</h6>
                      <p class="mb-1">{{ \Carbon\Carbon::parse($riwayat->created_at)->format('d F Y') }}</p>
                      <p class="mb-1">{{ $riwayat->keterangan }}</p>
                      <p class="mb-1 text-muted">{{ $riwayat->diagnosa }}</p>
                      <p class="mb-0">{{ $riwayat->obat }}</p>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>


      </div>
    </section>

  </section>
@endsection
