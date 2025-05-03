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

            <table id="tabel-validasi" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Surat</th>
                        <th>Jenis Surat</th>
                        <th>Tujuan</th>
                        <th>Status Draft</th>
                        {{-- <th>Nomor Surat</th> --}}
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="tabel-agenda">
                    @foreach ($suratKeluars as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_srt)->format('d/m/Y') }}
                                @if (!$item->is_read)
                                    <span class="badge bg-label-danger">Baru</span>
                                    {{-- <span class="badge bg-danger">Baru</span> --}}
                                @endif
                            </td>
                            {{-- <td class="wrap-text">{{ $item->perihal }}</td> --}}
                            <td>{{ $item->jenis_srt }}</td>
                            <td>{{ $item->instansi->nama_instansi }}</td>
                            <td>
                                @php
                                    $status = strtolower($item->status_validasi);
                                    $badgeClass = match ($status) {
                                        'belum' => 'bg-label-primary',
                                        'ditolak' => 'bg-label-danger',
                                        'final' => 'bg-label-success',
                                        'valid' => 'bg-label-warning',
                                        default => 'bg-label-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            {{-- <td>{{ $item->status_validasi }}</td> --}}
                            <td>
                                <a href="{{ route('surat-keluar.show', $item->id_sk) }}" class="btn btn-info btn-sm">
                                    Aksi
                                </a>
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

    </div>
@endsection


@push('script')
@endpush
