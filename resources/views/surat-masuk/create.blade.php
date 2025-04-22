@extends('layout.app')

@section('content')
    <div class="card">
        <h5 class="card-header">Form Surat Masuk</h5>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('surat-masuk.store') }}" method="POST" enctype="multipart/form-data" id="formSuratMasuk"
                class="row g-6 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                @csrf
                <!-- Account Details -->

                <div class="col-12">
                    <h6>1. Data Pengirim</h6>
                    <hr class="mt-0">
                </div>

                <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                    <label class="form-label" for="kota">Pilih atau ketik nama Instansi:</label>
                    <input class="form-control" placeholder="Pilih atau ketik nama instansi" list="instansiList"
                        id="nama_instansi" name="nama_instansi" autocomplete="off">
                    <datalist id="instansiList">
                        @foreach ($listInstansi as $instansi)
                            <option value="{{ $instansi->nama_instansi }}">{{ $instansi->nama_instansi }}</option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                    <label class="form-label" for="nama_pengirim">Nama Pengirim</label>
                    <input type="text" id="nama_pengirim" class="form-control" placeholder="John Doe"
                        name="nama_pengirim">
                </div>
                <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                    <label class="form-label" for="jabatan_pengirim">Jabatan Pengirim</label>
                    <input class="form-control" type="text" id="jabatan_pengirim" name="jabatan_pengirim"
                        placeholder="Jabatan (periode)">
                </div>

                <div class="col-md-12 form-control-validation fv-plugins-icon-container">
                    <label class="form-label" for="formValidationPass">Alamat Pengirim</label>
                    <textarea class="form-control" name="alamat_pengirim" id="alamat_pengirim" cols="30" rows="2"
                        placeholder="Masukkan alamat di sini ...."></textarea>
                </div>

                <!-- Personal Info -->

                <div class="col-12">
                    <h6 class="mt-2">2. Detail Isi Surat</h6>
                    <hr class="mt-0">
                </div>
                {{-- tgl_diterima, tgl_masuk, no. surat --}}
                <div class="col-md-4 col-12 mb-6">
                    <label for="flatpickr-date" class="form-label">Tanggal Diterima</label>
                    <input type="date" name="tanggal_terima" class="form-control" placeholder="DD-MM-YYYY (tgl-bln-thn)"
                        id="flatpickr-date" />
                </div>
                <div class="col-md-4 col-12 mb-6">
                    <label for="flatpickr-date" class="form-label">Tanggal Surat</label>
                    <input type="date" name="tanggal_srt" class="form-control" placeholder="DD-MM-YYYY (tgl-bln-thn)"
                        id="flatpickr-date2" />
                </div>
                <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" name="nomor_srt">
                </div>
                {{-- sifat surat, jenis surat, jenis agenda --}}
                <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                    <label for="sifat_srt" class="form-label">Sifat Surat</label>
                    <select id="defaultSelect" name="sifat_srt" class="form-select">
                        <option>Pilih Salah Satu</option>
                        <option value="Segera">Segera</option>
                        <option value="Sangat segera">Sangat Segera</option>
                        <option value="Rahasia">Rahasia</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="jenis_srt" class="form-label">Jenis Surat</label>
                    <select id="defaultSelect" id="jenis_srt" name="jenis_srt" class="form-select">
                        <option>Pilih Salah Satu</option>
                        <option value="Surat Dinas">Surat Dinas</option>
                        <option value="Undangan">Undangan</option>
                        <option value="Surat Keputusan">Surat Keputusan</option>
                        <option value="Surat Permohonan">Surat Permohonan</option>
                        <option value="Surat Izin">Surat Izin</option>
                        <option value="Surat Pemberitahuan">Surat Pemberitahuan</option>
                        <option value="Surat Lamaran">Surat Lamaran</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="agenda" class="form-label">Jenis Agenda</label>
                    <select id="defaultSelect" name="agenda" class="form-select">
                        <option>Pilih Salah Satu</option>
                        @foreach ($agenda as $agenda)
                            <option value="{{ $agenda->id_agenda }}">{{ $agenda->nama_bagian }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Perihal --}}
                <div class="col-md-12">
                    <label class="form-label" for="perihal">Perihal</label>
                    <textarea class="form-control" name="perihal" id="perihal" cols="30" rows="2"></textarea>
                </div>
                {{-- File Surat --}}
                <div class="col-md-12">
                    <label class="form-label" for="file">File Scan Surat Masuk</label>
                    <input class="form-control" type="file" name="file" id="file">
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



@push('script')
    <script src="{{ asset('assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
    <script src="{{ asset('assets/js/form-picker.js') }}"></script>
    <script>
        $('#nama_instansi').on('change', function() {
            let namaInstansi = $(this).val();

            $.ajax({
                url: '{{ route('get.instansi') }}',
                type: 'GET',
                data: {
                    nama_instansi: namaInstansi
                },
                success: function(res) {
                    if (res) {
                        let jabatan = (res.jabatan_pengirim || '') + ' (' + (res.periode_pengirim ||
                            '') + ')';
                        $('#jabatan_pengirim').val(jabatan.trim()).attr('readonly', true);
                        $('#nama_pengirim').val(res.nama_pengirim || '').attr('readonly', true);
                        $('#alamat_pengirim').val(res.alamat_pengirim || '').attr('readonly', true);
                    } else {
                        $('#nama_pengirim').val('').removeAttr('readonly');
                        $('#jabatan_pengirim').val('').removeAttr('readonly');
                        $('#alamat_pengirim').val('').removeAttr('readonly');
                    }
                },
                error: function() {
                    console.log('Gagal ambil data instansi.');
                    $('#nama_pengirim').val('').removeAttr('readonly');
                    $('#jabatan_pengirim').val('').removeAttr('readonly');
                    $('#alamat_pengirim').val('').removeAttr('readonly');
                }
            });
        });
    </script>
@endpush
