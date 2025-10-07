@extends('admin.layouts.app')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Tabel User</h3>
        <ul class="breadcrumbs mb-3">
          <li class="nav-home">
            <a href="#">
              <i class="fas fa-user-friends"></i>
            </a>
          </li>
          <li class="separator">
            <i class="icon-arrow-right"></i>
          </li>
          <li class="nav-item">
            <a href="#">User</a>
          </li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="card-title m-0">Data User</h4>

              <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                <i class="fas fa-user-plus"></i> Tambah User
              </a>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th style="display:none;">No</th>
                      <th>Nama</th>
                      <th>Tanggal Lahir</th>
                      <th>Jenis Kelamin</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $index => $user)
                      <tr>
                        <td style="display:none;">{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                          @if ($user->userDetail && $user->userDetail->tanggal_lahir)
                            {{ \Carbon\Carbon::parse($user->userDetail->tanggal_lahir)->format('d-m-Y') }}
                          @else
                            <em style="color: maroon">Belum dilengkapi</em>
                          @endif
                        </td>
                        <td>
                          @if ($user->userDetail && $user->userDetail->jenis_kelamin)
                            {{ $user->userDetail->jenis_kelamin }}
                          @else
                            <em style="color: maroon">Belum dilengkapi</em>
                          @endif
                        </td>
                        <td>{{ $user->userDetail->alamat }}</td>
                        <td>
                          <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalEditUser{{ $user->id }}">
                            <i class="fas fa-edit"></i>
                          </a>

                          <form action="{{ route('admin.delete.user', $user->id) }}" method="POST"
                            style="display:inline;" class="form-delete-user">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-delete-user"
                              data-username="{{ $user->name }}">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>
                        </td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>

                {{-- Modal untuk Tambah User --}}
                <div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content shadow-lg rounded-3">
                      <form action="{{ route('admin.tambah.user') }}" method="POST">
                        @csrf

                        <div class="modal-header bg-primary text-white">
                          <h5 class="modal-title fw-semibold" id="modalTambahUserLabel">Tambah User</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                        </div>

                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6">
                              <!-- Nama -->
                              <div class="mb-3">
                                <label for="nama" class="form-label fw-semibold">Nama</label>
                                <input type="text" name="nama" class="form-control fs-5" id="nama" required>
                              </div>

                              <!-- Email -->
                              <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control fs-5" id="email" required>
                              </div>

                              <!-- Password -->
                              <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control fs-5" id="password" required>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <!-- Alamat -->
                              <div class="mb-3">
                                <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                <textarea name="alamat" class="form-control fs-5" id="alamat" rows="3"></textarea>
                              </div>

                              <!-- Nomor HP -->
                              <div class="mb-3">
                                <label for="no_hp" class="form-label fw-semibold">Nomor HP</label>
                                <input type="text" name="no_hp" class="form-control fs-5" id="no_hp">
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
                {{-- Akhir dari Modal Tambah User --}}

                {{-- Modal untuk Edit User --}}
                @foreach ($users as $index => $user)
                  <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1"
                    aria-labelledby="modalEditUserLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                      <div class="modal-content shadow-lg rounded-3">
                        <form action="{{ route('admin.update.user', $user->id) }}" method="POST">
                          @csrf
                          @method('PATCH')

                          <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title fw-semibold" id="modalEditUserLabel{{ $user->id }}">Edit
                              User {{ $user->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                              aria-label="Tutup"></button>
                          </div>

                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-6 mb-3">
                                <label for="editNama{{ $user->id }}" class="form-label fw-semibold">Nama</label>
                                <input type="text" name="name" class="form-control fs-5"
                                  id="editNama{{ $user->id }}" value="{{ $user->name }}" required>
                              </div>

                              <div class="col-md-6 mb-3">
                                <label for="editEmail{{ $user->id }}" class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control fs-5"
                                  id="editEmail{{ $user->id }}" value="{{ $user->email }}" required>
                              </div>

                              <div class="col-md-6 mb-3">
                                <label for="editPassword{{ $user->id }}" class="form-label fw-semibold">Password
                                  (Opsional)
                                </label>
                                <input type="password" name="password" class="form-control fs-5"
                                  id="editPassword{{ $user->id }}">
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                              </div>

                              <div class="col-md-6 mb-3">
                                <label for="editAlamat{{ $user->id }}"
                                  class="form-label fw-semibold">Alamat</label>
                                <textarea name="alamat" class="form-control fs-5" id="editAlamat{{ $user->id }}" rows="3">{{ $user->userDetail->alamat }}</textarea>
                              </div>

                              <div class="col-md-6 mb-3">
                                <label for="editNomorHp{{ $user->id }}" class="form-label fw-semibold">Nomor
                                  HP</label>
                                <input type="text" name="no_hp" class="form-control fs-5"
                                  id="editNomorHp{{ $user->id }}" value="{{ $user->userDetail->no_hp }}">
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
                {{-- Akhir Modal untuk Edit User --}}

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
          text: `Data user dengan nama "${username}" akan dihapus!`,
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
