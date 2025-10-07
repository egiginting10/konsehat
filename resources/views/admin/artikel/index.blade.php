@extends('admin.layouts.app')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3 class="fw-bold mb-3">Tabel Artikel</h3>
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
            <a href="#">Artikel</a>
          </li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="card-title m-0">Data Artikel</h4>

              <a href="{{ route('admin.tambah.artikel') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Tambah Artikel
              </a>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th style="display:none;">No</th>
                      <th>Judul Artikel</th>
                      <th>Tanggal Terbit</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($artikels as $index => $artikel)
                      <tr>
                        <td style="display:none;">{{ $artikel->id }}</td>
                        <td>{{ $artikel->judul }}</td>
                        <td>{{ \Carbon\Carbon::parse($artikel->tanggal_terbit)->format('d-m-Y') }}</td>
                        <td>
                          <a href="{{ route('admin.edit.artikel', $artikel->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                          </a>

                          <form action="{{ route('admin.delete.artikel', $artikel->id) }}" method="POST"
                            style="display:inline;" class="form-delete-user">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger btn-delete-user"
                              data-username="{{ $artikel->judul }}">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>
                        </td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>

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
          text: `Artikel "${username}" akan dihapus!`,
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
