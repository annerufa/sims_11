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
        $waka = auth()->user()->jabatan !== 'ks' && auth()->user()->jabatan !== 'admin' ? 1 : 0;
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
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
@endpush
