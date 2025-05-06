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
        <h5 class="card-header">Detail Surat Masuk </h5>
        <div class="card-body">
            {{-- <div class="col-12">
                <h5>1. Data Su</h5>
                <hr class="mt-0">
            </div> --}}

            <div class="col-12">
                <table class="table table-hover detail-text ">
                    <thead>
                        <tr>
                            <td class="kolom1">Identitas Pengirim</td>
                            <td>: {{ $dataSurat->instansi->nama_pengirim }}</td>
                            <td colspan="2"> {{ $dataSurat->instansi->jabatan_pengirim }} -
                                {{ $dataSurat->instansi->nama_instansi }}
                            </td>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="kolom1">Jenis Surat</td>
                            <td>: {{ $dataSurat->jenis_srt }}</td>
                            <td class="kolom1">Sifat Surat</td>
                            @php
                                $sifat = strtolower($dataSurat->sifat_srt);
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
                            <td>: {{ \Carbon\Carbon::parse($dataSurat->tanggal_terima)->format('d/m/Y') }}
                            </td>
                            <td class="kolom1">Tanggal Surat</td>
                            <td>: {{ \Carbon\Carbon::parse($dataSurat->tanggal_srt)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="kolom1">No Agenda</td>
                            <td>:{{ $dataSurat->nomor_urut }}/{{ $dataSurat->agenda->nama_bagian }}</td>
                            <td class="kolom1">Nomor Surat</td>
                            <td>: {{ $dataSurat->nomor_srt }}</td>
                        </tr>
                        <tr>
                            <td class="kolom1">Perihal</td>
                            <td colspan="3">: {{ $dataSurat->perihal }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <hr class="mt-2">
                <p>File surat:</p>

                <!-- Atau untuk menampilkan langsung di iframe -->
                {{-- <iframe src="{{ Storage::url($dataSurat->file) }}" width="100%" height="600px" style="border: none;"> --}}
                <iframe src="{{ asset($dataSurat->file) }}" width="100%" height="600px" style="border: none;">
                </iframe>
                <hr class="mt-2 mb-4">
            </div>
            @php $tindak = false;   @endphp
            <div class="col-12">
                <div class="row card-header flex-column flex-md-row pb-0 mb-5">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <h5 class="card-title mb-0 text-md-start text-center">Daftar Disposisi</h5>
                    </div>
                    @if (auth()->user()->jabatan === 'ks')
                        <div
                            class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#modalDisposisi">
                                Buat Disposisi
                            </button>
                        </div>
                    @endif
                </div>
                <table class="table table-hover detail-text ">
                    <thead>
                        <tr style="font-weight: bold;">
                            <td>Diteruskan kepada</td>
                            <td>Dengan hormat harap</td>
                            <td>catatan</td>
                            <td>status</td>
                        </tr>
                    </thead>
                    <tbody id="tabel-agenda">

                        @foreach ($disposisi as $disposisiItem)
                            <tr>
                                <!-- Diteruskan kepada -->
                                <td>
                                    @foreach ($disposisiItem->penerimas as $penerima)
                                        <span class="penerima {{ $loop->iteration % 2 == 0 ? 'even' : 'odd' }}">
                                            {{ $penerima->nama }}
                                        </span>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </td>

                                <!-- Dengan hormat harap -->
                                @php
                                    $perintahArray = explode(', ', $disposisiItem->perintah);
                                @endphp

                                <td>
                                    @foreach ($perintahArray as $item)
                                        <span>{{ $item }}</span><br>
                                    @endforeach
                                </td>

                                <!-- Catatan -->
                                <td>{{ $disposisiItem->catatan }}</td>

                                <!-- Status -->
                                <td>

                                    {{-- @if (auth()->user()->jabatan === 'ks' || auth()->user()->jabatan === 'admin') --}}
                                    @foreach ($disposisiItem->penerimas as $penerima)
                                        @if (!$penerima->pivot->status_tugas)
                                            'belum ada tindak lanjut'
                                            @php
                                                if ($penerima->id == auth()->id()) {
                                                    $tindak = true;
                                                }
                                            @endphp
                                        @else
                                            <span class="status"> 'telah ditindak lanjuti'</span>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="mb-5">
                    {{-- status --}}
                    @if ((auth()->user()->jabatan === 'ks' || auth()->user()->jabatan === 'admin') && $tindak)
                        <a href="{{ route('disDone', $disposisi->id_disposisi) }}" class="btn btn-info">Tindak
                            lanjuti</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalDisposisi" tabindex="-1" aria-labelledby="modalDisposisiLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formDisposisi" action="{{ route('disposisi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="surat_masuk_id" value="{{ $dataSurat->id_sm }}">
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
@endpush
