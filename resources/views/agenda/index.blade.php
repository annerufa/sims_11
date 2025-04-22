@extends('layout.app')

@section('content')
    <div class="card">
        {{-- <h5 class="card-header">Daftar Surat Masuk</h5>
        <button class="btn btn-primary mb-3 " data-bs-toggle="modal" data-bs-target="#addAgendaModal">Tambah Surat
            Masuk</button> --}}
        <div class="row card-header flex-column flex-md-row pb-0 mb-5">
            <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                <h5 class="card-title mb-0 text-md-start text-center">Daftar Kode Agenda</h5>
            </div>
            <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                <button class="btn btn-primary mb-3 " data-bs-toggle="modal" data-bs-target="#addAgendaModal">Tambah Surat
                    Masuk</button>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            {{-- <table class="table"> --}}


            @if (session('success'))
                <div class="alert alert-success" id="auto-dismiss-alert" style="position: fixed;z-index: 9999;width:1057px;">
                    {{ session('success') }}
                </div>
            @endif
            <div id="aler" style="position: fixed;z-index: 9999;width:1057px;">

            </div>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Agenda</th>
                        <th>Nama Bagian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-agenda">
                    @foreach ($agenda as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kode_bagian }}</td>
                            <td>{{ $item->nama_bagian }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editAgendaModal" data-id="{{ $item->id_agenda }}">Ubah</button>

                                <form action="{{ route('agenda.destroy', $item->id_agenda) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal tambah -->
        <div class="modal fade" id="addAgendaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="formAddSuratMasuk" action="{{ route('agenda.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Kode Agenda</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-6">
                                    <label for="kodeBagian" class="form-label">Kode Agenda</label>
                                    <input type="text" name="kode_bagian" id="kodeBagian" class="form-control"
                                        placeholder="Masukkan Kode">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-6">
                                    <label for="namaBagian" class="form-label">Nama Divisi / Bagian</label>
                                    <input type="text" name="nama_bagian" id="namaBagian" class="form-control"
                                        placeholder="Nama Bagian">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Update --}}
        <div class="modal fade" id="editAgendaModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="formEditAgenda" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="number" id="EidAgenda" name="id_agenda" hidden />
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Surat Masuk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-6">
                                    <label for="kodeBagian" class="form-label">Kode Agenda</label>
                                    <input type="text" name="kode_bagian" id="EkodeBagian" class="form-control"
                                        placeholder="Masukkan Kode">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-6">
                                    <label for="namaBagian" class="form-label">Nama Divisi / Bagian</label>
                                    <input type="text" name="nama_bagian" id="EnamaBagian" class="form-control"
                                        placeholder="Nama Bagian">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alert = document.getElementById('auto-dismiss-alert');

            if (alert) {
                setTimeout(function() {
                    alert.style.transition = "opacity 1s";
                    alert.style.opacity = "0";

                    setTimeout(function() {
                        alert.remove();
                    }, 1000);
                }, 2000);
            }
        });
    </script>
    <!-- JavaScript untuk handle edit -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tangkap event ketika modal edit akan dibuka
            $('#editAgendaModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);

                var id = button.data('id');
                var modal = $(this);

                // Ambil data via AJAX
                $.get('/agenda/' + id + '/edit', function(data) {

                    console.log("get its" + id + data.kode_bagian);
                    // Isi form dengan data.val(id);
                    $('#EidAgenda').val(data.id_agenda);
                    $('#EkodeBagian').val(data.kode_bagian);
                    $('#EnamaBagian').val(data.nama_bagian);


                    // Update form action
                    $('#formEditAgenda').attr('action', '/agenda/' + id);

                    // Sembunyikan loading, tampilkan form
                    $('#loadingEdit').hide();
                    $('#formEditContent').show();
                });
            });
        });

        // update 
        $('#formEditAgenda').on('submit', function(e) {
            // var formMessages = $(this).data('id');$('#');
            e.preventDefault();
            let id = $('#EidAgenda').val();
            var data = $(this).serialize();

            const csrfToken = document.querySelector('input[name="_token"]').value;

            console.log(csrfToken);
            $.ajax({
                url: `/agenda/${id}`,
                type: "PUT",
                cache: false,
                data: data,
                success: function(response) {
                    refreshTable(response, csrfToken);
                    $('#editAgendaModal').modal('hide');
                    showAlert(response.message);
                    $('html').scrollTop(0);
                    $("#formEditAgenda")[0].reset();
                }
            });
        });
        // delete

        $('body').delegate('#tabel-user #del', 'click', function(e) {
            var id = $(this).data('id');
            $('#del_id').val(id);
            // $('#namaKar').val(id);
            $('#modalHapus').modal('show');
        });

        $('#yakin_hapus').click(function() {
            var id = $('#del_id').val();

            $.ajax({
                url: "user/" + id,
                type: 'DELETE',
                dataType: "JSON",
                data: {
                    "id": id,
                    "_token": $('#token').val()
                },
                success: function(response) {
                    refreshTable(response);
                    $('#modalHapus').modal('hide');
                    showAlert(response.message);
                    $('html').scrollTop(0);
                }
            });
        })

        function refreshTable(response, token) {
            $('#tabel-agenda').html('');
            $.each(response.data.agendas, function(index, obj) {
                $('#tabel-agenda').append('' +
                    '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + obj.kode_bagian + '</td>' +
                    '<td>' + obj.nama_bagian + '</td>' +
                    '<td>' +
                    '<button class="btn btn-warning btn-sm" data-bs-toggle="modal"' +
                    ' data-bs-target="#editAgendaModal" data-id="' + obj.id_agenda + '">Ubah</button>' +
                    ' <form action="/agenda/' + obj.id_agenda + '" method="POST"' +
                    ' class="d-inline">' +
                    '<input type="hidden" name="_token" value="' + token + '">' +
                    '<input type="hidden" name="_method" value="DELETE">' +
                    '<button type="submit" class="btn btn-danger btn-sm"' +
                    ' onclick="return confirm(\'Apakah Anda yakin?\')">Hapus</button>' +
                    '</form>' +
                    '</td>' +
                    '</tr>')

            });
        }

        function showAlert(msg) {
            document.getElementById("aler").innerHTML =
                '<div class="alert alert-success" id="auto-dismiss-alert" style="position: fixed;z-index: 9999;width:1057px;">' +
                msg + '</div>';
            $(".alert").fadeTo(3000, 500).slideUp(500, function() {
                $(".alert").alert('close');
            });

        }
    </script>
@endpush
