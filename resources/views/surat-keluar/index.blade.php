@extends('layout.app')
@push('style')
    <style>
        .wrap-text {
            white-space: normal;
            word-wrap: break-word;
            max-width: 300px;
        }
    </style>
@endpush
@section('content')
    @php
        $role = Auth::user()->jabatan; // misalnya 'admin' atau 'kepala_sekolah'
    @endphp
    <div class="card">
        <div class="row card-header flex-column flex-md-row pb-0 mb-5">
            <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                <h5 class="card-title mb-0 text-md-start text-center">Daftar Surat Keluar</h5>
            </div>
            @if (auth()->user()->jabatan === 'admin')
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                    <a href="{{ route('surat-keluar.create') }}">
                        <button class="btn btn-primary mb-3 ">Tambah Surat Keluar</button>
                    </a>
                    {{-- <button class="btn btn-primary mb-3 " data-bs-toggle="modal" data-bs-target="#addAgendaModal">Tambah Surat Masuk</button> --}}
                </div>
            @endif
        </div>
        <div class="table-responsive text-nowrap">

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
                        <th>Tanggal Surat</th>
                        <th>Pengaju</th>
                        <th>Jenis Surat</th>
                        <th>Tujuan</th>
                        {{-- <th>Nomor Surat</th> --}}
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="tabel-agenda">
                    @foreach ($suratKeluars as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_srt)->format('d/m/Y') }}
                                @if ($role === 'ks' && !$item->is_read)
                                    <span class="badge bg-label-danger">Baru</span>
                                    {{-- <span class="badge bg-danger">Baru</span> --}}
                                @endif
                                {{-- @if (!$item->is_read)
                                    <span class="badge bg-label-danger">Baru</span>
                                @endif --}}
                            </td>
                            {{-- <td class="wrap-text">{{ $item->perihal }}</td> --}}
                            <td>{{ $item->pengaju }}</td>
                            <td>{{ $item->jenis_srt }}
                                @php
                                    $status = strtolower($item->status_validasi);
                                    $badgeClass = match ($status) {
                                        'belum' => 'bg-label-primary',
                                        'ditolak' => 'bg-label-danger',
                                        'final' => 'bg-label-success',
                                        'disetujui' => 'bg-label-info',
                                        'direvisi' => 'bg-label-warning',
                                        default => 'bg-label-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>{{ $item->instansi->nama_instansi }}</td>
                            <td>
                                <a href="{{ route('surat-keluar.show', $item->id_sk) }}" class="btn btn-info btn-sm">
                                    Detail
                                </a>
                                @if ($role === 'admin')
                                    @if ($item->status_validasi == 'disetujui')
                                        <a href="{{ route('arsipSk', $item->id_sk) }}"
                                            class="btn btn-warning btn-sm">Upload Arsip
                                        </a>
                                    @elseif($item->status_validasi !== 'final')
                                        <a href="{{ route('surat-keluar.edit', $item->id_sk) }}"
                                            class="btn btn-warning btn-sm">Ubah
                                        </a>

                                        <form action="{{ route('surat-keluar.destroy', $item->id_sk) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                        </form>
                                        {{-- @elseif($role === 'admin' && !$item->is_read) --}}
                                    @endif
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal tambah -->
        <div class="modal fade" id="addAgendaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="formAddSuratMasuk" action="{{ route('surat-keluar.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Surat Keluar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-6">
                                    <label for="kodeBagian" class="form-label">Nama Instansi</label>
                                    <input type="text" name="nama_instansi" id="kodeBagian" class="form-control"
                                        placeholder="Masukkan Nama Instansi">
                                </div>
                            </div>
                            <div class="row g-6">
                                <div class="col mb-6">
                                    <label for="emailBasic" class="form-label">Nama Pengirim</label>
                                    <input type="text" name="nama_pengirim" id="emailBasic" class="form-control"
                                        placeholder="Mr. Boom">
                                </div>
                                <div class="col mb-6">
                                    <label for="dobBasic" class="form-label">Jabatan Pengirim</label>
                                    <input type="text" name="jabatan_pengirim" id="dobBasic" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-6">
                                    <label for="namaBagian" class="form-label">Periode Pengirim</label>
                                    <input type="text" name="periode_pengirim" id="namaBagian" class="form-control"
                                        placeholder="2023-2024">
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
                        <input type="number" id="EidInstansi" name="id_agenda" hidden />
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Instansi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col mb-6">
                                    <label for="kodeBagian" class="form-label">Nama Instansi</label>
                                    <input type="text" name="nama_instansi" id="enama_instansi" class="form-control"
                                        placeholder="Masukkan Nama Instansi">
                                </div>
                            </div>
                            <div class="row g-6">
                                <div class="col mb-6">
                                    <label for="emailBasic" class="form-label">Nama Pengirim</label>
                                    <input type="text" name="nama_pengirim" id="enama_pengirim" class="form-control"
                                        placeholder="Mr. Boom">
                                </div>
                                <div class="col mb-6">
                                    <label for="dobBasic" class="form-label">Jabatan Pengirim</label>
                                    <input type="text" name="jabatan_pengirim" id="ejabatan_pengirim"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-6">
                                    <label for="namaBagian" class="form-label">Periode Pengirim</label>
                                    <input type="text" name="periode_pengirim" id="eperiode_pengirim"
                                        class="form-control" placeholder="2023-2024">
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
                $.get('/surat-masuk/' + id + '/edit', function(data) {

                    console.log("get its" + id + data.nama_instansi);
                    // Isi form dengan data.val(id);
                    $('#EidInstansi').val(data.id_instansi);
                    $('#enama_instansi').val(data.nama_instansi);
                    $('#enama_pengirim').val(data.nama_pengirim);
                    $('#ejabatan_pengirim').val(data.jabatan_pengirim);
                    $('#eperiode_pengirim').val(data.periode_pengirim);


                    // Update form action
                    $('#formEditAgenda').attr('action', '/instansi/' + id);

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
            let id = $('#EidInstansi').val();
            var data = $(this).serialize();

            const csrfToken = document.querySelector('input[name="_token"]').value;

            console.log(csrfToken);
            $.ajax({
                url: `/surat-masuk/${id}`,
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
            $.each(response.data.instansis, function(index, obj) {
                $('#tabel-agenda').append('' +
                    '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + obj.nama_instansi + '</td>' +
                    '<td>' + obj.nama_pengirim + '</td>' +
                    '<td>' + obj.jabatan_pengirim + '</td>' +
                    '<td>' + obj.periode_pengirim + '</td>' +
                    '<td>' +
                    '<button class="btn btn-warning btn-sm" data-bs-toggle="modal"' +
                    ' data-bs-target="#editAgendaModal" data-id="' + obj.id_instansi + '">Ubah</button>' +
                    ' <form action="/surat-masuk/' + obj.id_instansi + '" method="POST"' +
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
