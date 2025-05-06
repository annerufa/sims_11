@extends('layout.app')
@push('style')
    <style>
        .wrap-text {
            white-space: normal;
            word-wrap: break-word;
            max-width: 350px;
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
                        <th>Tgl Disposisi</th>
                        <th>Perintah</th>
                        <th>Catatan</th>
                        <th>Perihal</th>
                        <th>Status</th>
                        {{-- <th>Nomor Surat</th> --}}
                        <th>Aksi</th>
                    </tr>
                </thead>
                {{-- {{ $item->penerima->first()->pivot->status_baca }} --}}
                <tbody id="tabel-agenda">
                    @foreach ($disposisi as $key => $item)
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
                            <td class="wrap-text">{{ $item['catatan'] }}</td>
                            <td class="wrap-text">{{ $item['surat_masuk']->perihal }}</td>
                            <td>
                                @if ($item['status_tugas'])
                                    <span class="badge badge-success">Sudah Ditindak lanjut</span>
                                @else
                                    <span class="badge badge-warning">Belum Ditindak lanjut</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('detailWaka', $item['id_disposisi']) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Detail
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
