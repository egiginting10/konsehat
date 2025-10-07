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
        <h4 class="page-title">Tambah Artikel</h4>
      </div>

      <div class="card">
        <div class="card-body" style="background-color: rgb(226, 223, 223)">
          <form action="{{ route('admin.store.artikel') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label for="judul" class="form-label fw-semibold">Judul</label>
              <input type="text" name="judul" id="judul" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="konten" class="form-label fw-semibold">Konten</label>
              <textarea name="konten" id="konten" class="form-control" rows="6"></textarea>
            </div>

            <div class="mb-3">
              <label for="gambar_artikel" class="form-label fw-semibold">Gambar Artikel</label>
              <input type="file" name="gambar_artikel" id="gambar_artikel" class="form-control">
            </div>

            <div class="mb-3">
              <label for="tanggal_terbit" class="form-label fw-semibold">Tanggal Terbit</label>
              <input type="date" name="tanggal_terbit" id="tanggal_terbit" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Artikel</button>
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
