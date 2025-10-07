@extends('layouts.app')

@section('content')
  <section class="hero container">
    <div class="row align-items-center w-100">
      <!-- Left Column -->
      <div class="col-md-6">
        <p style="color: black; margin-bottom: 30px; font-size: 40px; font-weight: bold">Halo, {{ Auth::user()->name }}.
          <span style="color: #007bff">Temukan</span>
        </p>
        <h2 style="color: black">Solusi Kesehatan Cepat dan Tepat</h2>
        <p class="text-muted">Layanan cepat dan informasi seputar kesehatan</p>

        <!-- Flex Container -->
        <div class="d-flex gap-4 mt-3">
          <!-- Item 1 -->
          <div class="text-center">
            <img src="{{ asset('img/cari-dokter.png') }}" alt="" style="width: 60px;">
            <p class="mt-2"><a href="{{ route('dokter') }}">Cari Dokter</a></p>
          </div>
          <!-- Item 2 -->
          <div class="text-center">
            <img src="{{ asset('img/artikel.png') }}" alt="" style="width: 60px;">
            <p class="mt-2"><a href="{{ route('artikel') }}">Artikel</a></p>
          </div>
          <!-- Item 3 -->
          {{-- <div class="text-center">
            <img src="{{ asset('img/chat.png') }}" alt="" style="width: 60px;">
            <p class="mt-2"><a href="">Chat Dokter</a></p>
          </div> --}}
        </div>
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
@endsection
