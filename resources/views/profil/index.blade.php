@extends('layouts.app')

@section('body-inline-style', 'overflow-y: auto !important')

@section('content')
  <section class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow-sm border-0 rounded-4 p-4">
            <form action="{{ route('update.profil.user', $user->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
              <div class="text-center mb-4">
                <img
                  src="{{ $user->userDetail->foto_user ? asset('storage/img/foto/' . $user->userDetail->foto_user) : asset('img/1.png') }}"
                  alt="Foto Profil" class="rounded-circle shadow" width="120" height="120">
                <h4 class="mt-3 mb-0">{{ $user->name }}</h4>
                <small class="text-muted">Pasien</small>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="email" class="form-label fw-bold">Email</label>
                  <input type="email" id="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="col-md-6">
                  <label for="phone" class="form-label fw-bold">No. HP</label>
                  <input type="text" id="phone" class="form-control" value="{{ $user->userDetail->no_hp }}"
                    required>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="dob" class="form-label fw-bold">Tanggal Lahir</label>
                  <input type="date" id="dob" name="tanggal_lahir" class="form-control"
                    value="{{ optional($user->userDetail)->tanggal_lahir ?? '' }}" required>
                </div>
                <div class="col-md-6">
                  <label for="gender" class="form-label fw-bold">Jenis Kelamin</label>
                  <select id="gender" name="jenis_kelamin" class="form-control" required>
                    <option value="" disabled
                      {{ is_null(optional($user->userDetail)->jenis_kelamin) ? 'selected' : '' }}>
                      -- Silakan Pilih Jenis Kelamin --
                    </option>
                    <option value="Laki-laki"
                      {{ optional($user->userDetail)->jenis_kelamin === 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="Perempuan"
                      {{ optional($user->userDetail)->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                  </select>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="weight" class="form-label fw-bold">Berat Badan (kg)</label>
                  <input type="text" id="weight" name="berat_badan" class="form-control"
                    value="{{ optional($user->userDetail)->berat_badan ?? '' }}">
                </div>
                <div class="col-md-6">
                  <label for="height" class="form-label fw-bold">Tinggi Badan (cm)</label>
                  <input type="text" id="height" name="tinggi_badan" class="form-control"
                    value="{{ optional($user->userDetail)->tinggi_badan ?? '' }}">
                </div>
              </div>

              <div class="mb-3">
                <label for="address" class="form-label fw-bold">Alamat</label>
                <textarea id="address" name="alamat" class="form-control" rows="3" placeholder="Jl. Seturan No. 10, Yogyakarta"
                  required>{{ old('alamat', optional($user->userDetail)->alamat) }}</textarea>
              </div>

              <div class="mb-3">
                <label for="foto_user" class="form-label fw-bold">Foto Profil</label>
                <input class="form-control" type="file" id="foto_user" name="foto_user" accept="image/*">

                @if (optional($user->userDetail)->foto_user)
                  <div class="mt-2">
                    <img src="{{ asset('storage/img/foto/' . $user->userDetail->foto_user) }}" alt="Foto Profil"
                      width="100" class="img-thumbnail">
                  </div>
                @endif
              </div>

              <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-4">
                  <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
