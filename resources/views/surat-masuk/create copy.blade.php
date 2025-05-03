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
            <form method="POST"
                action="{{ isset($data) ? route('surat-masuk.update', $data->id_sm) : route('surat-masuk.store') }}"
                enctype="multipart/form-data" id="formSuratMasuk" class="row g-6 fv-plugins-bootstrap5 fv-plugins-framework">
                @csrf
                @if (isset($data))
                    @method('PUT')
                @endif
                {{-- <form action="{{ route('surat-masuk.store') }}" method="POST"novalidate="novalidate">
                @csrf --}}
                <!-- Account Details -->

                <div class="col-12">
                    <h6>1. Data Pengirim</h6>
                    <hr class="mt-0">
                </div>

                <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                    <label class="form-label" for="kota">Pilih atau ketik nama Instansi:</label>
                    <input class="form-control" placeholder="Pilih atau ketik nama instansi" list="instansiList"
                        id="nama_instansi" name="id_pengirim" autocomplete="off"
                        value="{{ old('nama_instansi', $data->instansi->nama_instansi ?? '') }}">
                    <datalist id="instansiList">
                        @foreach ($listInstansi as $instansi)
                            <option value="{{ $instansi->id_instansi }}"
                                {{ old('id_pengirim', $data->id_pengirim ?? '') == $instansi->id_instansi ? 'selected' : '' }}>
                                {{ $instansi->nama_instansi }}
                            </option>
                        @endforeach
                    </datalist>
                </div>
                <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                    <label class="form-label" for="nama_pengirim">Nama Pengirim</label>
                    <input type="text" id="nama_pengirim" class="form-control" placeholder="Abraham" name="nama_pengirim"
                        value="{{ old('nama_pengirim', $data->instansi->nama_pengirim ?? '') }}">
                </div>
                <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                    <label class="form-label" for="jabatan_pengirim">Jabatan Pengirim</label>
                    <input class="form-control" type="text" id="jabatan_pengirim" name="jabatan_pengirim"
                        placeholder="Jabatan (periode)"
                        value="{{ old('jabatan_pengirim', $data->instansi->jabatan_pengirim ?? '') }}">
                </div>

                <div class="col-md-12 form-control-validation fv-plugins-icon-container">
                    <label class="form-label" for="formValidationPass">Alamat Pengirim</label>
                    <textarea class="form-control" name="alamat_pengirim" id="alamat_pengirim" cols="30" rows="2"
                        placeholder="Masukkan alamat di sini ....">{{ old('alamat_pengirim', $data->instansi->alamat ?? '') }}</textarea>
                </div>

                <!-- Personal Info -->

                <div class="col-12">
                    <h6 class="mt-2">2. Detail Isi Surat</h6>
                    <hr class="mt-0">
                </div>
                {{-- tgl_diterima, tgl_masuk, no. surat --}}
                <div class="col-md-4 col-12 mb-6">
                    <label for="flatpickr-date" class="form-label">Tanggal Diterima</label>
                    <input type="date" name="tanggal_terima" class="form-control" id="tanggalSuratInput"
                        value="{{ old('tanggal_terima', $data->tanggal_terima ?? '') }}">
                    {{-- <input type="date" name="tanggal_terima" class="form-control" placeholder="DD-MM-YYYY (tgl-bln-thn)"
                        id="flatpickr-date" value="{{ old('tanggal_terima', $data->tanggal_terima ?? '') }}" /> --}}
                </div>
                <div class="col-md-4 col-12 mb-6">
                    <label for="flatpickr-date" class="form-label">Tanggal Surat</label>
                    <input type="date" name="tanggal_srt" class="form-control" placeholder="01-01-2001"
                        id="tanggal_srt" />
                </div>
                <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" name="nomor_srt"
                        value="{{ old('nomor_srt', $data->nomor_srt ?? '') }}">
                </div>
                {{-- sifat surat, jenis surat, jenis agenda --}}
                <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                    <label for="sifat_srt" class="form-label">Sifat Surat</label>
                    <select id="defaultSelect" name="sifat_srt" class="form-select">
                        <option disabled {{ old('sifat_srt', $data->sifat_srt ?? '') == '' ? 'selected' : '' }}>
                            Pilih Salah Satu
                        </option>
                        <option value="Biasa" {{ old('sifat_srt', $data->sifat_srt ?? '') == 'Biasa' ? 'selected' : '' }}>
                            Biasa
                        </option>
                        <option value="Segera"
                            {{ old('sifat_srt', $data->sifat_srt ?? '') == 'Segera' ? 'selected' : '' }}>
                            Segera
                        </option>
                        <option value="Sangat segera"
                            {{ old('sifat_srt', $data->sifat_srt ?? '') == 'Sangat segera' ? 'selected' : '' }}>
                            Sangat Segera
                        </option>
                        <option value="Rahasia"
                            {{ old('sifat_srt', $data->sifat_srt ?? '') == 'Rahasia' ? 'selected' : '' }}>
                            Rahasia
                        </option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="jenis_srt" class="form-label">Jenis Surat</label>
                    <select id="defaultSelect" id="jenis_srt" name="jenis_srt" class="form-select">
                        @foreach ($jenisSuratOptions as $option)
                            <option value="{{ $option }}"
                                {{ old('jenis_surat', $data->jenis_surat ?? '') == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-4">
                    <label for="agenda" class="form-label">Jenis Agenda</label>
                    <select id="defaultSelect" name="agenda_id" class="form-select">
                        <option>Pilih Salah Satu</option>
                        @foreach ($agenda as $agenda)
                            <option value="{{ $agenda->id_agenda }}"
                                {{ old('agenda', $data->agenda ?? '') == $agenda->id_agenda ? 'selected' : '' }}>
                                {{ $agenda->nama_bagian }}
                            </option>
                            {{-- <option value="{{ $agenda->id_agenda }}">{{ $agenda->nama_bagian }}</option> --}}
                        @endforeach
                    </select>
                </div>
                {{-- Perihal --}}
                <div class="col-md-12">
                    <label class="form-label" for="perihal">Perihal</label>
                    <textarea class="form-control" name="perihal" id="perihal" cols="30" rows="2">{{ old('perihal', $data->perihal ?? '') }}</textarea>
                </div>
                {{-- File Surat --}}
                <div class="col-md-12">
                    <label class="form-label" for="file">File Scan Surat Masuk</label>
                    <input class="form-control" type="file" name="file" id="file"
                        value="{{ old('file', $data->file ?? '') }}">
                </div>

                @if (isset($data) && $data->file)
                    <div class="mt-2">
                        <p>File saat ini:</p>

                        <!-- Atau untuk menampilkan langsung di iframe -->
                        <iframe src="{{ Storage::url($data->file) }}" width="100%" height="600px"
                            style="border: none;">
                        </iframe>
                        <a href="{{ Storage::url($data->file) }}">Download file</a>
                    </div>
                @endif

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
        flatpickr("#tanggalSuratInput", {
            dateFormat: "d-m-Y",
            defaultDate: @json(old(
                    'tanggal_terima',
                    isset($data) ? \Carbon\Carbon::parse($data->tanggal_terima)->format('d-m-Y') : now()->format('d-m-Y')))
        });
        flatpickr("#tanggal_srt", {
            dateFormat: "d-m-Y",
            defaultDate: @json(old(
                    'tanggal_srt',
                    isset($data) ? \Carbon\Carbon::parse($data->tanggal_srt)->format('d-m-Y') : now()->format('d-m-Y')))
        });
    </script>
    <script>
        $('#nama_instansi').on('change', function() {
            let selectedValue = $(this).val();

            // Cek apakah nilai yang dipilih adalah teks (nama instansi) atau angka (ID instansi)
            if (isNaN(selectedValue)) {
                // Jika teks (nama instansi), cari data instansi berdasarkan nama
                $.ajax({
                    url: '{{ route('get.instansi') }}',
                    type: 'GET',
                    data: {
                        nama_instansi: selectedValue
                    },
                    success: function(res) {
                        if (res) {
                            let jabatan = (res.jabatan_pengirim || '') +
                                (res.periode_pengirim ? ' (' + res.periode_pengirim + ')' : '');
                            $('#jabatan_pengirim').val(jabatan.trim()).attr('readonly', true);
                            $('#nama_pengirim').val(res.nama_pengirim || '').attr('readonly', true);
                            $('#alamat_pengirim').val(res.alamat || '').attr('readonly', true);

                            // Update nilai hidden ID jika diperlukan
                            $('input[name="id_pengirim"]').val(res.id_instansi);
                        } else {
                            resetInstansiFields();
                        }
                    },
                    error: function() {
                        console.log('Gagal ambil data instansi.');
                        resetInstansiFields();
                    }
                });
            } else {
                // Jika angka (ID instansi), cari data instansi berdasarkan ID
                $.ajax({
                    url: '{{ route('get.instansi') }}',
                    type: 'GET',
                    data: {
                        id_instansi: selectedValue
                    },
                    success: function(res) {
                        if (res) {
                            let jabatan = (res.jabatan_pengirim || '') +
                                (res.periode_pengirim ? ' (' + res.periode_pengirim + ')' : '');
                            $('#jabatan_pengirim').val(jabatan.trim()).attr('readonly', true);
                            $('#nama_pengirim').val(res.nama_pengirim || '').attr('readonly', true);
                            $('#alamat_pengirim').val(res.alamat || '').attr('readonly', true);
                        } else {
                            resetInstansiFields();
                        }
                    },
                    error: function() {
                        console.log('Gagal ambil data instansi.');
                        resetInstansiFields();
                    }
                });
            }
        });

        function resetInstansiFields() {
            $('#nama_pengirim').val('').removeAttr('readonly');
            $('#jabatan_pengirim').val('').removeAttr('readonly');
            $('#alamat_pengirim').val('').removeAttr('readonly');
        }
    </script>
@endpush
