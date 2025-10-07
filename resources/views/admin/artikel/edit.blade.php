@extends('admin.layouts.app')

@section('customCSS')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h4 class="page-title">Edit Artikel</h4>
      </div>

      <div class="row">
        <div class="col-md-12">
          <form action="{{ route('admin.update.artikel', $artikel->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
              <label for="judul" class="form-label fw-semibold">Judul Artikel</label>
              <input type="text" name="judul" id="judul" class="form-control"
                value="{{ old('judul', $artikel->judul) }}" required>
            </div>

            <div class="mb-3">
              <label for="gambar_artikel" class="form-label fw-semibold">Gambar Artikel</label>
              <input type="file" name="gambar_artikel" class="form-control">
              @if ($artikel->gambar_artikel)
                <small class="d-block mt-2">Gambar saat ini:</small>
                <img src="{{ asset('storage/' . $artikel->gambar_artikel) }}" alt="Gambar Artikel" width="200">
              @endif
            </div>

            <div class="mb-3">
              <label for="tanggal_terbit" class="form-label fw-semibold">Tanggal Terbit</label>
              <input type="date" name="tanggal_terbit" id="tanggal_terbit" class="form-control"
                value="{{ old('tanggal_terbit', $artikel->tanggal_terbit) }}" required>
            </div>

            <div class="mb-3">
              <label for="konten" class="form-label fw-semibold">Konten</label>
              <textarea name="konten" id="konten" class="form-control" rows="6">{{ old('konten', $artikel->konten) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Artikel</button>
            <a href="{{ route('admin.artikel') }}" class="btn btn-secondary">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('customJS')
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#konten').summernote({
        placeholder: 'Tulis konten artikel di sini...',
        height: 300,
        callbacks: {
          onInit: function() {
            $('.note-editable').css('background-color', 'white');
          }
        },
        tabsize: 2,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview']]
        ],
        callbacks: {
          onInit: function() {
            $('.note-editable').css('background-color', 'white');
          }
        }
      });
    });
  </script>
@endsection
