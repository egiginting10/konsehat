@extends('roleDokter.layouts.app')

@section('content')
  <div class="container">
    <div class="page-inner">
      <div class="page-header d-flex align-items-center justify-content-between">
        <div>
          <h3 class="fw-bold mb-3">Daftar Konsultasi</h3>
          {{-- <ul class="breadcrumbs mb-3">
            <li class="nav-home">
              <a href="#"><i class="fas fa-user-friends"></i></a>
            </li>
            <li class="separator">
              <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
              <a href="#">Daftar Konsultasi</a>
            </li>
          </ul> --}}
        </div>

        <div class="d-flex align-items-center p-3 border rounded bg-light shadow-sm" style="width: 15%">
          <p class="mb-0 fw-bold">Layanan Saya:</p>

          <form action="{{ route('konsultasi.toggle') }}" method="POST" class="m-0 ms-auto">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="status" value="{{ $statusActive->is_active === 1 ? 'non_aktif' : 'aktif' }}">

            <button type="submit"
              class="btn btn-lg d-flex align-items-center gap-2 px-2 rounded-pill 
            {{ $statusActive->is_active === 1 ? 'btn-danger' : 'btn-success' }}">
              @if ($statusActive->is_active === 1)
                <i class="bi bi-toggle-off fs-4"></i> Non Aktifkan
              @else
                <i class="bi bi-toggle-on fs-4"></i> Aktifkan
              @endif
            </button>
          </form>
        </div>

      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="card-title m-0">Data Konsultasi {{ Auth::user()->name }}</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table id="basic-datatables" class="display table table-striped table-hover">
                  <thead>
                    <tr>
                      <th style="display:none;">No</th>
                      <th>Nama</th>
                      <th>Chat</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($chats as $index => $chat)
                      <tr>
                        <td style="display:none;">{{ $chat->id }}</td>
                        <td>{{ $chat->name }}</td>
                        <td>
                          <a href="{{ route('dokter.get.chat', $chat->user_id) }}"
                            class="d-inline-block border border-primary rounded p-2 text-primary">
                            <i class="fas fa-arrow-right"></i>
                          </a>
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
    document.getElementById('toggleStatus').addEventListener('click', function() {
      let button = this;
      let currentStatus = button.getAttribute('data-status');
      let userId = "{{ auth()->id() }}";

      fetch('{{ route('konsultasi.toggle') }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            status: currentStatus,
            user_id: userId
          })
        })
        .then(response => response.json())
        .then(data => {
          button.setAttribute('data-status', data.status);
          button.textContent = data.status == 1 ? 'Aktif' : 'Non Aktif';
          button.classList.toggle('btn-success', data.status == 1);
          button.classList.toggle('btn-secondary', data.status == 0);
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
