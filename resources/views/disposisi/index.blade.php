@extends('layout.app')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/select2.css') }}">
    <style>
        .wrap-text {
            white-space: normal;
            word-wrap: break-word;
            max-width: 300px;
        }

        th {
            text-align: center;
            margin: auto;
        }
    </style>
@endpush
@section('content')
    <div class="card">
        <div class="row card-header flex-column flex-md-row pb-0 mb-5">
            <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                <h5 class="card-title mb-0 text-md-start text-center">Daftar Disposisi</h5>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            @if (session('error'))
                <div class="alert alert-danger" id="auto-dismiss-alert" style="position: fixed;z-index: 9999;width:1057px;">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success"style="position: fixed;z-index: 9999;width:1057px;">
                    {{ session('success') }}
                </div>
            @endif
            <div id="aler" style="position: fixed;z-index: 9999;width:1057px;">

            </div>

            <table id="tabel-validasi" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Disposisi</th>
                        <th>Perintah</th>
                        <th>Perihal</th>
                        <th>Status</th>
                        {{-- <th>Nomor Surat</th> --}}
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                {{-- {{ $item->penerima->first()->pivot->status_baca }} --}}
                <tbody id="tabel-agenda">
                    @foreach ($disposisi as $key => $item)
                        {{-- <?php $isDone = 0; ?> --}}
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item['tanggal_disposisi'])->format('d/m/Y') }}</td>
                            <td class="wrap-text">

                                @if (!empty($item['perintah']))
                                    {{ $item['perintah'] }}
                                @endif
                            </td>
                            {{-- <td>{{ \Carbon\Carbon::parse($item['surat_masuk']->tanggal_surat)->format('d/m/Y') }}</td> --}}
                            {{-- <td>{{  }}</td> --}}
                            {{-- <td class="wrap-text">{{ $item['catatan'] }}</td> --}}
                            <td class="wrap-text">{{ $item['surat_masuk']->perihal }}</td>
                            <td>
                                @foreach ($item['penerimas'] as $penerima)
                                    {{ $penerima['nama'] }}
                                    @if ($penerima['status_tugas'])
                                        <p> <span class="badge bg-label-success">Telah Ditindak lanjut</span>
                                        </p>
                                        {{-- @php $isDone=1; @endphp --}}
                                    @else
                                        <p> <span class="badge bg-label-warning">Belum Ditindak lanjut</span>
                                        </p>
                                    @endif
                                    {{-- @php $isDone = $penerima['is_read'] ? 1 : 0; @endphp
                                    {{ $isDone }} --}}
                                @endforeach

                            </td>

                            <td style="text-align: center;margin: auto;">
                                <a href="{{ route('detailWaka', $item['id_disposisi']) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                @php
                                    $bisaUbah = true; // Default tampilkan tombol
                                    foreach ($item['penerimas'] as $penerima) {
                                        if ($penerima['is_read']) {
                                            $bisaUbah = false; // Jika ada yang sudah baca, sembunyikan tombol
                                            break; // Keluar dari loop begitu ketemu satu yang true
                                        }
                                    }
                                @endphp

                                @if ($bisaUbah)
                                    <button id="ubahDisposisi" class="btn btn-sm btn-warning"
                                        data-id="{{ $item['id_disposisi'] }}" data-bs-toggle="modal"
                                        data-bs-target="#modalDisposisi" data-id-surat="{{ $item['surat_masuk_id'] }}">
                                        <i class="fas fa-eye"></i> Ubah
                                    </button>
                                    <form action="{{ route('disposisi.destroy', $item['id_disposisi']) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Menampilkan link pagination -->
            {{-- <div class="d-flex justify-content-center">
                {{ $suratKeluars->links() }}
            </div> --}}
        </div>
        <div class="modal fade" id="modalDisposisi" tabindex="-1" aria-labelledby="modalDisposisiLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formDisposisi" action="" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="disposisi_id" value="">
                    <input type="hidden" name="surat_masuk_id" id="surat_masuk_id" value="">
                    {{-- <input type="hidden" name="surat_masuk_id" value=""> --}}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDisposisiLabel">Buat Disposisi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="select2Dark" class="form-label">Diterusksn kepada Sdr:</label>
                                <div class="select2-dark">
                                    <select id="select2Dark" name="penerima[]" class="select2 form-select"
                                        multiple="multiple">
                                        @foreach ($users as $user)
                                            @if ($user->jabatan == 'ks')
                                                @continue
                                            @endif
                                            <option value="{{ $user->id }}">{{ $user->nama }} -
                                                {{ $user->jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Pilih satu atau lebih</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="select2Dark1" class="form-label">Dengan hormat harap:</label>
                                <div class="select2-dark">
                                    <select id="select2Dark1" name="perintah[]" class="select2 form-select"
                                        multiple="multiple">
                                        <option value="Tanggapan dan saran">Tanggapan dan saran</option>
                                        <option value="Proses lebih lanjut">Proses lebih lanjut</option>
                                        <option value="Koordinasi konfirmasi">Koordinasi konfirmasi</option>
                                        <option value="Sesuai dengan catatan">Sesuai dengan catatan</option>
                                    </select>
                                    <small class="text-muted">Pilih satu atau lebih</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="isi_disposisi" class="form-label">Catatan</label>
                                <textarea class="form-control" name="catatan" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Kirim Disposisi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection


@push('script')
    <script src="{{ asset('assets/vendor/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/form-select.js') }}"></script>
    <script src="{{ asset('assets/js/form-picker.js') }}"></script>
    <script>
        $(".select2").select2();
        $(".select2Dark1").select2();
    </script>
    <script>
        $(".alert").fadeTo(1500, 500).slideUp(500, function() {
            $(".alert").alert('close');
        });
    </script>
    <script>
        $(document).ready(function() {

            // Handle edit button click
            $(document).on('click', '#ubahDisposisi', function() {
                var idDisposisi = $(this).data('id');
                var idsurat = $(this).data('idSurat');
                var modal = $('#modalDisposisi');
                console.log(idsurat);
                // Set form action URL
                var form = $('#formDisposisi');
                form.attr('action', '/disposisi/' + idDisposisi);

                // Set hidden ID field
                $('#disposisi_id').val(idDisposisi);
                $('#surat_masuk_id').val(idsurat);
                // Load data via AJAX
                // url: '/disposisi/' + idDisposisi + '/edit',
                $.ajax({
                    url: "{{ route('disposisi.edit', ':id') }}".replace(':id', idDisposisi),
                    method: 'GET',
                    success: function(response) {
                        console.log(response.disposisi.perintah);
                        // Ubah string perintah menjadi array
                        var perintahArray = response.disposisi.perintah.split(',').map(
                            function(
                                item) {
                                return item.trim(); // Menghapus spasi di sekitar item
                            });
                        $('#select2Dark').val(response.penerima).trigger('change');
                        $('#select2Dark1').val(perintahArray).trigger('change');

                        $('textarea[name="catatan"]').val(response.disposisi.catatan);
                        console.log('Select2 Perintah:', $('#select2Dark1').select2(
                            'data'));
                        // Update modal UI
                        // Perintah (pastikan array of strings)
                        // var perintah = Array.isArray(response.perintah) ?
                        //     response.perintah : [response.perintah].filter(Boolean);
                        modal.find('.modal-title').text('Edit Disposisi');
                        modal.find('.btn-submit').text('Update');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
            // Reset modal when closed
            $('#modalDisposisi').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('.select2').val(null).trigger('change');
            });
        });
    </script>
    {{-- <script>
        $('#ubahDisposisi').on('click', function() {
       var idDisposisi = $(this).data('id');
       
       // Ambil data disposisi berdasarkan idDisposisi
       $.ajax({
         url: "{{ route('disposisi.edit', ':id') }}".replace(':id', idDisposisi),
        //    url: '/disposisi/' + idDisposisi, // Ganti dengan URL yang sesuai untuk mengambil data disposisi
           method: 'GET',
           success: function(data) {
               // Isi data ke dalam modal
               $('#select2Dark').val(data.penerima).trigger('change');
               $('#select2Dark1').val(data.perintah).trigger('change');
               $('textarea[name="catatan"]').val(data.catatan);
           }
       });
   });
   
    </script> --}}
@endpush
