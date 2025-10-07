@extends('roleDokter.layouts.app')

@section('customCSS')
  <style>
    .chat-bubble-left,
    .chat-bubble-right {
      border-radius: 15px;
      padding: 10px;
      word-wrap: break-word;
    }

    #preview-container {
      display: none;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 10px;
      margin-top: 10px;
      background: #fff;
    }

    #preview-container img {
      max-width: 150px;
      border-radius: 8px;
      margin-bottom: 5px;
    }
  </style>
@endsection

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="page-header">

      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card shadow rounded">
            <div class="card-header d-flex align-items-center justify-content-between bg-primary text-white">
              <div class="d-flex align-items-center">
                <img
                  src="{{ $chat->user->userDetail->foto_user ? asset('storage/img/foto/' . $chat->user->userDetail->foto_user) : asset('img/1.png') }}"
                  alt="Dokter" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                <div>
                  <h6 class="mb-0">{{ $chat->user->name }}</h6>
                  <small></small>
                </div>
              </div>
              <a href="{{ route('dokter.index') }}" class="btn btn-light btn-sm">Selesai</a>
            </div>

            <div class="card-body" style="height: 530px; overflow-y: auto; background-color: #e8eef5;">
              @foreach ($messages as $msg)
                @php
                  $extension = $msg->attachment ? strtolower(pathinfo($msg->attachment, PATHINFO_EXTENSION)) : null;
                  $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                  $isPDF = $extension === 'pdf';
                  $isWord = in_array($extension, ['doc', 'docx']);
                  $isExcel = in_array($extension, ['xls', 'xlsx']);
                  $isPPT = in_array($extension, ['ppt', 'pptx']);
                @endphp

                @if ($msg->sender_id === auth()->id())
                  <div class="d-flex justify-content-end mb-3">
                    <div class="chat-bubble-left bg-primary text-white p-2 rounded" style="max-width: 70%;">
                      <small>Anda</small><br>
                      <span>{{ $msg->message }}</span><br>
                      @if ($msg->attachment)
                        <br>
                        @if ($isImage)
                          <img src="{{ asset('storage/' . $msg->attachment) }}" alt="Lampiran Gambar"
                            style="max-width: 200px; height: auto; border-radius: 8px; margin-top: 5px;">
                        @elseif ($isPDF)
                          <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank"
                            class="text-light d-block mt-2">
                            <i class="fas fa-file-pdf fa-2x me-2 text-danger"></i> Lihat PDF
                          </a>
                        @elseif ($isWord)
                          <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank"
                            class="text-light d-block mt-2">
                            <i class="fas fa-file-word fa-2x me-2 text-primary"></i> Lihat Word
                          </a>
                        @elseif ($isExcel)
                          <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank"
                            class="text-light d-block mt-2">
                            <i class="fas fa-file-excel fa-2x me-2 text-success"></i> Lihat Excel
                          </a>
                        @elseif ($isPPT)
                          <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank"
                            class="text-light d-block mt-2">
                            <i class="fas fa-file-powerpoint fa-2x me-2 text-warning"></i> Lihat PowerPoint
                          </a>
                        @else
                          <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank"
                            class="text-light d-block mt-2">
                            Lihat Lampiran
                          </a>
                        @endif
                      @endif

                      <small class="text-light">
                        {{ $msg->created_at->setTimezone('Asia/Jakarta')->format('H:i') }}
                        @if ($msg->is_read)
                          <i class="fas fa-check-double text-black"></i>
                        @else
                          <i class="fas fa-check-double text-white"></i>
                        @endif
                      </small>
                    </div>
                  </div>
                @else
                  <div class="d-flex mb-3">
                    <div class="chat-bubble-right bg-white text-dark p-2 rounded" style="max-width: 70%;">
                      <small style="color: rgb(250, 20, 59)">{{ $msg->sender->name }}</small><br>
                      <span>{{ $msg->message }}</span><br>
                      @if ($msg->attachment)
                        <br>
                        @if ($isImage)
                          <img src="{{ asset('storage/' . $msg->attachment) }}" alt="Lampiran Gambar"
                            style="max-width: 200px; height: auto; border-radius: 8px; margin-top: 5px;">
                        @elseif ($isPDF)
                          <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank"
                            class="text-primary d-block mt-2">
                            <i class="fas fa-file-pdf fa-2x me-2 text-danger"></i> Lihat PDF
                          </a>
                        @elseif ($isWord)
                          <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank"
                            class="text-primary d-block mt-2">
                            <i class="fas fa-file-word fa-2x me-2 text-primary"></i> Lihat Dokumen Word
                          </a>
                        @else
                          <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank"
                            class="text-primary d-block mt-2">
                            Lihat Lampiran
                          </a>
                        @endif
                      @endif

                      <small
                        class="text-black">{{ \Carbon\Carbon::parse($msg->created_at)->setTimezone('Asia/Jakarta')->format('H:i') }}</small>
                    </div>
                  </div>
                @endif
              @endforeach
            </div>

            <div class="card-footer bg-white">
              <form id="chatForm" action="{{ route('dokter.chat.send') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                <input type="hidden" name="receiver_id" value="{{ $chat->dokter_id }}">

                <input type="file" id="fileInput" name="file" class="d-none" accept="image/*,.pdf">

                <div id="preview-container">
                  <div id="preview-content"></div>
                  <button type="button" id="remove-preview" class="btn btn-sm btn-danger">Hapus</button>
                  <div class="mt-2">
                    <input type="text" name="preview_message" class="form-control"
                      placeholder="Tulis pesan untuk lampiran ini...">
                  </div>
                </div>

                <div class="input-group mt-2">
                  <input type="text" name="message" class="form-control" placeholder="Ketik pesan...">
                  <button type="button" class="btn btn-secondary" id="uploadBtn">
                    <i class="fas fa-paperclip"></i>
                  </button>
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-paper-plane"></i>
                  </button>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>


    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const chatBody = document.querySelector(".card-body");
      const fileInput = document.getElementById("fileInput");
      const uploadBtn = document.getElementById("uploadBtn");
      const previewContainer = document.getElementById("preview-container");
      const previewContent = document.getElementById("preview-content");
      const removePreview = document.getElementById("remove-preview");

      uploadBtn.addEventListener("click", () => fileInput.click());

      fileInput.addEventListener("change", () => {
        if (fileInput.files.length > 0) {
          showPreview(fileInput.files[0]);
        }
      });

      function showPreview(file) {
        previewContent.innerHTML = '';
        const fileType = file.type;

        if (fileType.startsWith('image/')) {
          const img = document.createElement('img');
          img.src = URL.createObjectURL(file);
          previewContent.appendChild(img);
        } else if (fileType === 'application/pdf') {
          previewContent.innerHTML = `<p><i class="fas fa-file-pdf text-danger"></i> ${file.name}</p>`;
        } else {
          previewContent.innerHTML = `<p>File: ${file.name}</p>`;
        }

        previewContainer.style.display = 'block';
      }

      removePreview.addEventListener("click", () => {
        fileInput.value = '';
        previewContainer.style.display = 'none';
        previewContent.innerHTML = '';
      });

      chatBody.addEventListener("dragover", (e) => {
        e.preventDefault();
        chatBody.style.backgroundColor = "#dfe7f1";
      });

      chatBody.addEventListener("dragleave", () => {
        chatBody.style.backgroundColor = "#e8eef5";
      });

      chatBody.addEventListener("drop", (e) => {
        e.preventDefault();
        chatBody.style.backgroundColor = "#e8eef5";
        fileInput.files = e.dataTransfer.files;
        if (fileInput.files.length > 0) {
          showPreview(fileInput.files[0]);
        }
      });
    });
  </script>
@endsection
