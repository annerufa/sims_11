@extends('layout.app')
@push('style')
    <style>
        .hilang {
            display: none;
        }

        .cc {
            row-gap: 10px;
            margin-top: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="card">
        <h5 class="card-header">Form Surat Keluar</h5>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form method="POST" action="{{ route('uploadArsip', $data->id_sk) }}" enctype="multipart/form-data"
                id="formSuratMasuk" class="row g-6 fv-plugins-bootstrap5 fv-plugins-framework">
                @csrf

                <div class="col-12">
                    <h6>1. Upload Arsip Surat</h6>
                    <hr class="mt-0">
                </div>

                {{-- File Surat --}}
                <div class="col-md-12">
                    <label class="form-label" for="file_draft">File Draft Surat Keluar</label>
                    <input class="form-control" type="file" name="file_fiks" id="file_fiks">
                </div>
                <div class="col-12 form-control-validation">
                    <div class="d-grid">

                        <button type="submit" name="submitButton" class="btn btn-info">Simpan</button>
                    </div>
                </div>
                {{-- <input type="hidden"> --}}
            </form>
        </div>
    </div>
@endsection
