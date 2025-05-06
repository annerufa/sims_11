@extends('layout.app')
@push('style')
    <style>
        .detail-text {
            color: black;
            font-size: 14px;
        }

        td {
            white-space: normal;
            word-wrap: break-word;
            width: 250px;
        }

        .kolom1 {
            margin-left: 20px;
            border-left: 1px solid black;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/select2.css') }}">
@endpush
@section('content')
    <div class="card">
        <h5 class="card-header">Data Disposisi > detail</h5>
        <div class="card-body">
            <div class="col-12">
                <h6>1. Data disposisi</h6>
                <hr class="mt-0">
            </div>
            <div class="col-12">
                <table class="table table-hover detail-text ">
                    <thead>
                        <tr style="font-weight: bold;">
                            <td>Diteruskan kepada</td>
                            <td>Status Tindakan</td>
                            <td>Dengan hormat harap</td>
                            <td>catatan</td>
                        </tr>
                    </thead>
                    <tbody id="tabel-agenda">
                        {{-- @foreach ($disposisi as $disposisiItem) --}}
                        <tr>
                            <!-- Diteruskan kepada -->
                            {{-- <td> --}}
                            @php
                                $tindak = false; // Initialize as false
                            @endphp

                            @foreach ($disposisi->penerimas as $penerima)
                                <td>
                                    <span class="penerima {{ $loop->iteration % 2 == 0 ? 'even' : 'odd' }}">
                                        {{ $penerima->nama }}</span>
                                </td>
                                <td>
                                    @if (!$penerima->pivot->status_tugas)
                                        'belum ada tindak lanjut'
                                    @else
                                        'telah ditindak lanjuti'
                                    @endif
                                    @php
                                        if (!$penerima->pivot->status_tugas && $penerima->id == auth()->id()) {
                                            $tindak = true;
                                        }
                                    @endphp
                                    <!-- You can add visual indicator here if needed -->
                                    {{-- <i class="fas fa-check-circle text-success"></i> --}}
                                    {{-- @endif --}}
                                </td>
                            @endforeach


                            <!-- Dengan hormat harap -->
                            @php
                                $perintahArray = explode(', ', $disposisi->perintah);
                            @endphp

                            <td>
                                @foreach ($perintahArray as $item)
                                    <span>{{ $item }}</span><br>
                                @endforeach
                            </td>

                            <!-- Catatan -->
                            <td>{{ $disposisi->catatan }}</td>



                        </tr>
                        {{-- @endforeach --}}

                    </tbody>
                </table>
                <br>
                <div class="mb-5">
                    {{-- status --}}
                    @if ($tindak)
                        <a href="{{ route('disDone', $disposisi->id_disposisi) }}" class="btn btn-info">Tindak
                            lanjuti</a>
                    @endif
                </div>
            </div>
            <div class="col-12">
                <h6>2. Data Detail Surat</h6>
                <hr class="mt-0">
            </div>
            <div class="col-12">
                <table class="table table-hover detail-text ">
                    <thead>
                        <tr>
                            <td class="kolom1">Identitas Pengirim</td>
                            <td>: {{ $disposisi->suratMasuk->instansi->nama_pengirim }}</td>
                            <td colspan="2"> {{ $disposisi->suratMasuk->instansi->jabatan_pengirim }} -
                                {{ $disposisi->suratMasuk->instansi->nama_instansi }}
                            </td>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="kolom1">Jenis Surat</td>
                            <td>: {{ $disposisi->suratMasuk->jenis_srt }}</td>
                            <td class="kolom1">Sifat Surat</td>
                            @php
                                $sifat = strtolower($disposisi->suratMasuk->sifat_srt);
                                $badgeClass = match ($sifat) {
                                    'biasa' => 'bg-label-primary',
                                    'rahasia' => 'bg-label-danger',
                                    'segera' => 'bg-label-success',
                                    'sangat segera' => 'bg-label-warning',
                                    default => 'bg-label-secondary',
                                };
                            @endphp
                            <td>
                                <span class="badge {{ $badgeClass }}">
                                    : {{ ucfirst($sifat) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="kolom1">Tanggal Diterima</td>
                            <td>: {{ \Carbon\Carbon::parse($disposisi->suratMasuk->tanggal_terima)->format('d/m/Y') }}
                            </td>
                            <td class="kolom1">Tanggal Surat</td>
                            <td>: {{ \Carbon\Carbon::parse($disposisi->suratMasuk->tanggal_srt)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="kolom1">No Agenda</td>
                            <td>:{{ $disposisi->suratMasuk->nomor_urut }}/{{ $disposisi->suratMasuk->agenda->nama_bagian }}
                            </td>
                            <td class="kolom1">Nomor Surat</td>
                            <td>: {{ $disposisi->suratMasuk->nomor_srt }}</td>
                        </tr>
                        <tr>
                            <td class="kolom1">Perihal</td>
                            <td colspan="3">: {{ $disposisi->suratMasuk->perihal }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <hr class="mt-2">
                <p>File surat:</p>

                <!-- Atau untuk menampilkan langsung di iframe -->
                {{-- <iframe src="{{ Storage::url($disposisi->suratMasuk->file) }}" width="100%" height="600px" style="border: none;"> --}}
                <iframe src="{{ asset($disposisi->suratMasuk->file) }}" width="100%" height="600px"
                    style="border: none;">
                </iframe>
                <hr class="mt-2 mb-4">
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/vendor/js/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/form-select.js') }}"></script>
    <script src="{{ asset('assets/js/form-picker.js') }}"></script>

    <script>
        // Ambil CSRF token dari meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('#formDisposisi').on('submit', function(e) {
                e.preventDefault(); // Cegah reload halaman

                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize(); // Ambil semua data form

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    success: function(response) {
                        // Tutup modal dan reset form jika sukses
                        $('#modalDisposisi').modal('hide');
                        form[0].reset();
                        $('.select2').val(null).trigger('change');

                        // Tampilkan notifikasi (opsional)
                        alert('Disposisi berhasil dikirim!');

                        refreshTable(response);
                    },
                    error: function(xhr) {
                        // Tampilkan error (bisa kamu sesuaikan)
                        alert('Terjadi kesalahan saat mengirim disposisi.');
                        console.log(xhr.responseText);
                    }
                });
            });
        });

        function refreshTable(response) {
            $('#tabel-agenda').html(''); // Kosongkan tabel terlebih dahulu

            $.each(response.data, function(index, obj) {
                let perintahArray = obj.perintah.split(', '); // Split berdasarkan koma dan spasi

                // Membuat HTML untuk perintah dengan <span> dan <br>
                let perintahHtml = perintahArray.map(item => `<span>${item}</span><br>`).join('');

                // Menambahkan baris data ke tabel
                $('#tabel-agenda').append('' +
                    '<tr>' +
                    // '<td>' + (index + 1) + '</td>' + // Nomor urut
                    '<td>' + obj.penerimas.map(penerima => penerima.user.nama).join(', ') + '</td>' +
                    // Daftar penerima
                    '<td>' + perintahHtml + '</td>' + // Perintah yang sudah dibentuk
                    '<td>' + obj.catatan + '</td>' +
                    '<td>' +
                    '<button class="btn btn-warning btn-sm" data-bs-toggle="modal"' +
                    ' data-bs-target="#editAgendaModal" data-id="' + obj.id_disposisi + '">Ubah</button>' +
                    ' <form action="/disposisi/' + obj.id_disposisi + '" method="POST"' +
                    ' class="d-inline">' +
                    '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                    '<input type="hidden" name="_method" value="DELETE">' +
                    '<button type="submit" class="btn btn-danger btn-sm"' +
                    ' onclick="return confirm(\'Apakah Anda yakin?\')">Hapus</button>' +
                    '</form>' +
                    '</td>' +
                    '</tr>'
                );
            });
        }
    </script>
@endpush
