@extends('layouts.app')

@section('customCSS')
  <style>
    .status-indicator {
      position: absolute;
      top: 10px;
      right: 10px;
      width: 14px;
      height: 14px;
      border-radius: 50%;
      border: 2px solid #fff;
    }

    .bg-success {
      background-color: #28a745 !important;
    }

    .bg-secondary {
      background-color: #6c757d !important;
    }
  </style>
@endsection

@section('content')
  @if (session('error'))
    <div id="success-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  <section class="py-5">
    <div class="container-fluid">
      <div class="row d-flex">
        <!-- Left Column -->
        <div class="col-md-4 text-center mb-4 d-flex flex-column justify-content-start">
          <div class="pe-3">
            <h3 class="fw-bold">Chat Dokter di KONSEHAT</h3>
            <p class="text-muted">Layanan konsultasi yang cepat dan tepat</p>

            <img src="{{ asset('img/side-icon.png') }}" alt="Gambar Dokter" class="img-fluid my-3">

            <p class="fw-semibold">Pilih Dokter yang tepat lalu chat sekarang</p>

            <img src="{{ asset('img/docter.png') }}" alt="Gambar Besar" class="img-fluid"
              style="height: 600px; object-fit: contain; width: 100%; opacity: 0.8;">
          </div>
        </div>

        <div class="col-md-8 overflow-auto" style="height: 700px;">
          <div class="mb-4 pt-3">
            <form method="GET" action="{{ route('dokter.list') }}" class="input-group w-50 mx-auto">
              <input type="hidden" name="spesialisasi" value="{{ request('spesialisasi') }}">
              <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-search text-muted"></i>
              </span>
              <input type="text" name="nama" class="form-control border-start-0" value="{{ request('nama') }}"
                placeholder="Cari Dokter">
              <button type="submit" class="btn btn-primary">Cari</button>
            </form>
          </div>
          <div class="mb-1">
            <a href="{{ url('dokter') }}">
              <i class="fa-solid fa-arrow-left me-2"></i>Kembali
            </a>
          </div>

          @if ($dokterList->isEmpty())
            <div class="col-12">
              <div class="alert alert-warning text-center">
                {{ $message ?? 'Belum ada Daftar Dokter.' }}
              </div>
            </div>
          @else
            <div class="row px-3">
              <!-- Doctor Cards -->
              @foreach ($dokterList as $dokter)
                <div class="col-md-4 mb-3">
                  <div class="card h-100 mb-4 shadow-sm position-relative">

                    {{-- Indikator Status --}}
                    <span
                      class="status-indicator {{ $dokter->user->is_active ? 'bg-success' : 'bg-secondary' }} }}"></span>

                    <img src="{{ asset('storage/' . $dokter->foto_dokter) }}" class="card-img-top img-fluid"
                      alt="Foto Dokter" style="width: 100%; height: 200px; object-fit: contain;">

                    <div class="card-body d-flex flex-column text-center">
                      <h6 class="card-title mb-1">
                        Dr {{ $dokter->user->name ?? 'Tanpa Nama' }} Spesialis
                        {{ ucwords(strtolower($dokter->spesialisasi)) }}
                      </h6>
                      <div class="mt-auto">
                        <a href="{{ route('dokter.chat', ['dokterId' => $dokter->user_id]) }}"
                          class="btn btn-primary btn-sm w-100">Chat</a>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach

            </div>
          @endif


        </div>
      </div>
    </div>
  </section>
@endsection
