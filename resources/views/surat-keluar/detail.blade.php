@extends('layout.app')
@push('style')
    <style>
        .detail-text {
            color: black;
            font-size: 14px;
        }

        .hilang {
            display: none;
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

        .btn-valid {
            display: block;
            width: 100%;
        }
    </style>

    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/select2.css') }}"> --}}
@endpush
@section('content')
    <div class="card">
        @if ($dataSurat->status_validasi !== 'final')
            <h5 class="card-header">Detail Draft Surat Keluar</h5>
        @else
            <h5 class="card-header">Detail Surat Keluar </h5>
        @endif
        <div class="card-body">
            <div class="col-12">
                <table class="table table-hover detail-text ">

                    <tbody>
                        <tr>
                            <td class="kolom1">Kepada</td>
                            <td>: {{ $dataSurat->instansi->nama_pengirim }}</td>
                            <td colspan="2"> {{ $dataSurat->instansi->jabatan_pengirim }} -
                                {{ $dataSurat->instansi->nama_instansi }}
                            </td>

                        </tr>
                        <tr>
                            <td class="kolom1">Pengaju Surat</td>
                            <td>: {{ $dataSurat->pengaju }}</td>
                            <td class="kolom1">Jenis Surat</td>
                            <td>: {{ $dataSurat->jenis_srt }}

                            </td>
                        </tr>
                        <tr>
                            <td class="kolom1">Status Surat</td>
                            <td>:
                                {{-- @if ($dataSurat->status_validasi === 'final')
                                    {{ $dataSurat->nomor_srt }}
                                @else --}}
                                @php
                                    $sifat = strtolower($dataSurat->status_validasi);
                                    $badgeClass = match ($sifat) {
                                        'belum' => 'bg-label-primary',
                                        'ditolak' => 'bg-label-danger',
                                        'final' => 'bg-label-success',
                                        'valid' => 'bg-label-warning',
                                        default => 'bg-label-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($sifat) }}
                                </span>
                                {{-- @endif --}}

                            </td>
                            <td class="kolom1">Tanggal Surat</td>
                            <td>: {{ \Carbon\Carbon::parse($dataSurat->tanggal_srt)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="kolom1">Validator</td>
                            <td>:{{ $dataSurat->validator->nama }}</td>
                            <td class="kolom1">No Surat</td>
                            <td>: {{ $dataSurat->agenda->kode_bagian }} / {{ $dataSurat->nomor_urut }} / 101.6.11.13 /
                                {{ \Carbon\Carbon::parse($dataSurat->tanggal_srt)->format('Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="kolom1">Perihal</td>
                            <td colspan="3">: {{ $dataSurat->perihal }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12 mt-4">
                @if ($dataSurat->status_validasi === 'direvisi')
                    <div class="alert alert-primary alert-dismissible" role="alert">
                        <h5 class="alert-heading d-flex align-items-center flex-wrap gap-1 mb-1">Catatan Revisi</h5>
                        <p class="mb-0">{{ $dataSurat->catatan_revisi }}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="col-12">
                <hr class="mb-2 mt-3">
                <p>File surat:</p>
                @if ($dataSurat->status_validasi !== 'final')
                    <iframe src="{{ asset($dataSurat->file_draft) }}" width="100%" height="600px" style="border: none;">
                    @else
                        <iframe src="{{ asset($dataSurat->file_fiks) }}" width="100%" height="600px"
                            style="border: none;">
                @endif

                </iframe>
            </div>
            @if (auth()->user()->jabatan !== 'ks' && auth()->user()->jabatan !== 'admin')
                <div class="row mt-5">
                    <div class="col-6">
                        <button class="btn btn-warning btn-valid" id="btn-revisi" type="button">Revisi Surat</button>
                        {{-- <button id="btn-revisi"></button> --}}
                    </div>
                    <div class="col-6">
                        <a href="{{ route('setujui', $dataSurat->id_sk) }}">
                            <button class="btn btn-info btn-valid">Setujui</button>
                        </a>
                    </div>
                </div>
            @endif

        </div>
        <div class="card-body hilang" id="form-revisi">
            <h5>Revisi Draft Surat Keluar</h5>
            <form action="{{ route('revisi') }}" method="POST">
                @csrf
                <input type="hidden" name="id_sk" value="{{ $dataSurat->id_sk }}">
                <div class="col-12">
                    <textarea class="form-control" name="catatan_revisi" id="" cols="30" rows="4"></textarea>
                </div>
                <div class="col-12 mt-3">
                    <div class="d-grid">
                        <button type="submit" name="submitButton" class="btn btn-info">Simpan Revisi</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('script')
    {{-- <script src="{{ asset('assets/vendor/js/select2.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/js/form-select.js') }}"></script>
    <script src="{{ asset('assets/js/form-picker.js') }}"></script>
    <script>
        $(".select2").select2();
        $(".select2Dark1").select2();
    </script>
    <script>
        $('#btn-revisi').on('click', function() {

            // const select = document.getElementById('tujuan');
            const formBaru = document.getElementById('form-revisi');
            formBaru.classList.remove('hilang');
        });
    </script>
@endpush
