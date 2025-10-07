@extends('roleDokter.layouts.app')

@section('customCSS')
  <style>
    .select2-container--default .select2-selection--single {
      font-size: 1rem !important;
      border: 2px solid #ebedf2 !important;
      padding: .6rem 1rem;
      height: inherit !important;
      border-radius: .25rem !important;
      line-height: normal !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: inherit !important;
      padding-left: 0 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 100% !important;
      right: 10px !important;
    }
  </style>
@endsection
@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Daftar Riwayat Konsultasi</h3>
        <ul class="breadcrumbs mb-3">
          <li class="nav-home">
            <a href="#">
              <i class="fas fa-book-reader"></i>
            </a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="#">Riwayat Konsultasi</a>
          </li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="card-title m-0">Riwayat Konsultasi {{ Auth::user()->name }}</h4>

              <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahRiwayat">
                <i class="fas fa-user-plus"></i> Tambah Riwayat
              </a>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th style="display:none;">No</th>
                      <th>Nama</th>
                      <th>Jenis Kelamin</th>
                      <th>Diagnosa</th>
                      <th>Obat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($riwayats as $index => $riwayat)
                      <tr>
                        <td style="display:none;">{{ $riwayat->id }}</td>
                        <td>{{ $riwayat->name }}</td>
                        <td>{{ $riwayat->jenis_kelamin }}</td>
                        <td>{{ $riwayat->diagnosa }}</td>
                        <td>{{ $riwayat->obat }}</td>
                        <td>
                          <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalEditRiwayat{{ $riwayat->id }}">
                            <i class="fas fa-edit"></i>
                          </a>

                          <form action="{{ route('dokter.delete.konsul', $riwayat->id) }}" method="POST"
                            style="display:inline;" class="form-delete-user">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-delete-user"
                              data-username="{{ $riwayat->name }}">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>
                        </td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>

                {{-- Modal untuk Tambah Riwayat --}}
                <div class="modal fade" id="modalTambahRiwayat" tabindex="-1" aria-labelledby="modalTambahRiwayatLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content shadow-lg rounded-3">
                      <form action="{{ route('dokter.konsul') }}" method="POST">
                        @csrf

                        <div class="modal-header bg-primary text-white">
                          <h5 class="modal-title fw-semibold" id="modalTambahUserLabel">Tambah Riwayat</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                        </div>

                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="mb-3">
                                <label for="user_id" class="form-label fw-semibold">Nama</label>
                                <select name="user_id" id="user_id" class="form-select select2 fs-5" required>
                                  <option value="">-- Pilih Nama --</option>
                                  @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                  @endforeach
                                </select>
                              </div>

                              <div class="mb-3">
                                <label for="diagnosa" class="form-label fw-semibold">Diagnosa</label>
                                <input type="text" name="diagnosa" class="form-control fs-5" id="diagnosa" required>
                              </div>

                              <div class="mb-3">
                                <label for="obat" class="form-label fw-semibold">Obat</label>
                                <input type="text" name="obat" class="form-control fs-5" id="obat" required>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="mb-3">
                                <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                                <textarea name="keterangan" class="form-control fs-5" id="keterangan" rows="3"></textarea>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal-footer bg-light">
                          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                {{-- Akhir dari Modal Tambah Riwayat --}}

                {{-- Modal untuk Edit Riwayat --}}
                @foreach ($riwayats as $index => $riwayat)
                  <div class="modal fade" id="modalEditRiwayat{{ $riwayat->id }}" tabindex="-1"
                    aria-labelledby="modalEditRiwayatLabel-{{ $riwayat->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                      <div class="modal-content shadow-lg rounded-3">
                        <form action="{{ route('dokter.konsul.update', $riwayat->id) }}" method="POST">
                          @csrf
                          @method('PATCH')

                          <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title fw-semibold" id="modalEditRiwayatLabel-{{ $riwayat->id }}">Edit
                              Riwayat</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                              aria-label="Tutup"></button>
                          </div>

                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label for="user_id" class="form-label fw-semibold">Nama</label>
                                  <select name="user_id" id="user_id" class="form-select select2-edit fs-5" required>
                                    @foreach ($users as $user)
                                      <option value="{{ $user->id }}"
                                        {{ $user->id == $riwayat->user_id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                      </option>
                                    @endforeach
                                  </select>
                                </div>

                                <div class="mb-3">
                                  <label for="diagnosa" class="form-label fw-semibold">Diagnosa</label>
                                  <input type="text" name="diagnosa" class="form-control fs-5"
                                    value="{{ $riwayat->diagnosa }}" required>
                                </div>

                                <div class="mb-3">
                                  <label for="obat" class="form-label fw-semibold">Obat</label>
                                  <input type="text" name="obat" class="form-control fs-5"
                                    value="{{ $riwayat->obat }}" required>
                                </div>
                              </div>

                              <div class="col-md-6">
                                <div class="mb-3">
                                  <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                                  <textarea name="keterangan" class="form-control fs-5" rows="3">{{ $riwayat->keterangan }}</textarea>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary btn-sm"
                              data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning btn-sm">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                @endforeach
                {{-- Akhir Modal untuk Edit Riwayat --}}

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('customJS')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    $(document).ready(function() {
      $('.select2').select2({
        dropdownParent: $('#modalTambahRiwayat')
      });

      $('[id^="modalEditRiwayat"]').on('shown.bs.modal', function() {
        $(this).find('.select2-edit').select2({
          dropdownParent: $(this)
        });
      });

    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.querySelectorAll('.btn-delete-user').forEach(function(button) {
      button.addEventListener('click', function(e) {
        e.preventDefault();

        const form = this.closest('form');
        const username = this.getAttribute('data-username');

        Swal.fire({
          title: 'Yakin menghapus data?',
          text: `Data Riwayat Konsul "${username}" akan dihapus!`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  </script>


  <script>
    $(document).ready(function() {
      $("#basic-datatables").DataTable({
        order: [
          [0, 'desc']
        ]
      });

      $("#multi-filter-select").DataTable({
        pageLength: 5,
        initComplete: function() {
          this.api()
            .columns()
            .every(function() {
              var column = this;
              var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                .appendTo($(column.footer()).empty())
                .on("change", function() {
                  var val = $.fn.dataTable.util.escapeRegex($(this).val());

                  column
                    .search(val ? "^" + val + "$" : "", true, false)
                    .draw();
                });

              column
                .data()
                .unique()
                .sort()
                .each(function(d, j) {
                  select.append(
                    '<option value="' + d + '">' + d + "</option>"
                  );
                });
            });
        },
      });

      // Add Row
      $("#add-row").DataTable({
        pageLength: 5,
      });

      var action =
        '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

      $("#addRowButton").click(function() {
        $("#add-row")
          .dataTable()
          .fnAddData([
            $("#addName").val(),
            $("#addPosition").val(),
            $("#addOffice").val(),
            action,
          ]);
        $("#addRowModal").modal("hide");
      });
    });
  </script>
@endsection
