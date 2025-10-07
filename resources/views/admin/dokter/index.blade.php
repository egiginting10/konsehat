@extends('admin.layouts.app')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Tabel Daftar Dokter</h3>
        <ul class="breadcrumbs mb-3">
          <li class="nav-home">
            <a href="#">
              <i class="fas fa-user-md"></i>
            </a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="#">Daftar Dokter</a>
          </li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="card-title m-0">Data Dokter</h4>

              <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahDokter">
                <i class="fas fa-user-plus"></i> Tambah Dokter
              </a>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th style="display:none;">No</th>
                      <th>Nama</th>
                      <th>Spesialisasi</th>
                      <th>Jenis Kelamin</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($dokters as $index => $dokter)
                      <tr>
                        <td style="display:none;">{{ $dokter->id }}</td>
                        <td>{{ $dokter->name }}</td>
                        <td>{{ $dokter->dokterDetail->spesialisasi }}</td>
                        <td>
                          @if ($dokter->dokterDetail && $dokter->dokterDetail->jenis_kelamin)
                            {{ $dokter->dokterDetail->jenis_kelamin }}
                          @else
                            <em style="color: maroon">Belum dilengkapi</em>
                          @endif
                        </td>

                        <td>
                          <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalEditDokter{{ $dokter->id }}">
                            <i class="fas fa-edit"></i>
                          </a>

                          <form action="{{ route('admin.delete.dokter', $dokter->dokterDetail->id) }}" method="POST"
                            style="display:inline;" class="form-delete-user">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-delete-user"
                              data-username="{{ $dokter->name }}">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                  {{-- Modal untuk Edit Dokter --}}
                  @foreach ($dokters as $index => $dokter)
                    <div class="modal fade" id="modalEditDokter{{ $dokter->id }}" tabindex="-1"
                      aria-labelledby="modalEditUserLabel{{ $dokter->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg rounded-3">
                          <form action="{{ route('admin.update.dokter', $dokter->dokterDetail->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="modal-header bg-dark text-white">
                              <h5 class="modal-title fw-semibold" id="modalEditDokterLabel{{ $dokter->id }}">Edit
                                Dokter {{ $dokter->name }}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                            </div>

                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label for="nama" class="form-label fw-semibold">Nama</label>
                                    <input type="text" name="nama" class="form-control fs-5"
                                      value="{{ $dokter->name }}" required>
                                  </div>

                                  <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control fs-5"
                                      value="{{ $dokter->email }}" required>
                                  </div>

                                  <div class="mb-3">
                                    <label for="no_hp" class="form-label fw-semibold">Nomor HP</label>
                                    <input type="text" name="no_hp" class="form-control fs-5"
                                      value="{{ $dokter->dokterDetail->no_hp }}">
                                  </div>

                                  <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control fs-5"
                                      value="{{ $dokter->dokterDetail->tanggal_lahir }}">
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <div class="mb-3">
                                    <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                    <textarea name="alamat" class="form-control fs-5" rows="3">{{ $dokter->dokterDetail->alamat }}</textarea>
                                  </div>

                                  <div class="mb-3">
                                    <label for="spesialisasi" class="form-label fw-semibold">Spesialisasi</label>
                                    <input type="text" name="spesialisasi" class="form-control fs-5"
                                      value="{{ $dokter->dokterDetail->spesialisasi }}">
                                  </div>

                                  <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select fs-5">
                                      <option value="Laki-laki"
                                        {{ $dokter->dokterDetail->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                      <option value="Perempuan"
                                        {{ $dokter->dokterDetail->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                    </select>
                                  </div>

                                  <div class="mb-3">
                                    <label for="foto_dokter" class="form-label fw-semibold">Foto Dokter
                                      (Opsional)
                                    </label>
                                    <input type="file" name="foto_dokter" class="form-control fs-5">
                                    @if ($dokter->dokterDetail->foto_dokter)
                                      <img src="{{ asset('storage/' . $dokter->dokterDetail->foto_dokter) }}"
                                        alt="Foto" class="img-thumbnail mt-2" width="100">
                                    @endif
                                  </div>
                                </div>
                              </div>

                              <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary btn-sm"
                                  data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                              </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  @endforeach
                  {{-- Akhir Modal untuk Edit Dokter --}}
                </table>

                {{-- Modal untuk Tambah Dokter --}}
                <div class="modal fade" id="modalTambahDokter" tabindex="-1" aria-labelledby="modalTambahDokterLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content shadow-lg rounded-3">
                      <form action="{{ route('admin.tambah.dokter') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-header bg-primary text-white">
                          <h5 class="modal-title fw-semibold" id="modalTambahUserLabel">Tambah Dokter</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                        </div>

                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6">

                              <div class="mb-3">
                                <label for="nama" class="form-label fw-semibold">Nama</label>
                                <input type="text" name="nama" class="form-control fs-5" id="nama"
                                  required>
                              </div>

                              <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control fs-5" id="email"
                                  required>
                              </div>

                              <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control fs-5" id="password"
                                  required>
                              </div>

                              <div class="mb-3">
                                <label for="spesialisasi" class="form-label fw-semibold">Spesialisasi</label>
                                <input type="text" name="spesialisasi" class="form-control fs-5" id="spesialisasi"
                                  required>
                              </div>

                              <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control fs-5"
                                  id="tanggal_lahir" required>
                              </div>

                            </div>

                            <div class="col-md-6">

                              <div class="mb-3">
                                <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                <textarea name="alamat" class="form-control fs-5" id="alamat" rows="3"></textarea>
                              </div>

                              <div class="mb-3">
                                <label for="no_hp" class="form-label fw-semibold">Nomor HP</label>
                                <input type="text" name="no_hp" class="form-control fs-5" id="no_hp">
                              </div>

                              <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control fs-5" required>
                                  <option value="" disabled selected>-- Pilih --</option>
                                  <option value="Laki-laki">Laki-laki</option>
                                  <option value="Perempuan">Perempuan</option>
                                </select>
                              </div>

                              <div class="mb-3">
                                <label for="foto_dokter" class="form-label fw-semibold">Foto Dokter</label>
                                <input type="file" name="foto_dokter" id="foto_dokter" class="form-control fs-5"
                                  accept="image/*">
                              </div>

                            </div>
                          </div>
                        </div>

                        <div class="modal-footer bg-light">
                          <button type="button" class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                {{-- Akhir dari Modal Tambah Dokter --}}


              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('customJS')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.querySelectorAll('.btn-delete-user').forEach(function(button) {
      button.addEventListener('click', function(e) {
        e.preventDefault();

        const form = this.closest('form');
        const username = this.getAttribute('data-username');

        Swal.fire({
          title: 'Yakin menghapus data?',
          text: `Data Dokter dengan nama "${username}" akan dihapus!`,
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
