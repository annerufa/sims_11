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
            <form method="POST" action="{{ route('revisiDone', $data->id_sk) }}" enctype="multipart/form-data"
                id="formSuratMasuk" class="row g-6 fv-plugins-bootstrap5 fv-plugins-framework">
                @csrf
                <div class="col-12">
                    <h6>1. Tujuan Surat</h6>
                    <hr class="mt-0">
                </div>

                <div class="col-md-12 form-control-validation fv-plugins-icon-container">
                    <label class="form-label" for="tujuan">Pilih Tujuan Surat:</label>
                    <select id="tujuan" name="tujuan" class="form-select">
                        <option disabled selected value="">Pilih Salah Satu</option>
                        <option value="new">+ Tambah Tujuan Baru</option>
                        @foreach ($listInstansi as $instansi)
                            <option value="{{ $instansi->id_instansi }}"
                                {{ old('tujuan', $data->tujuan ?? '') == $instansi->id_instansi ? 'selected' : '' }}>
                                ({{ $instansi->nama_pengirim }})
                                <br>{{ $instansi->jabatan_pengirim }} -
                                {{ $instansi->nama_instansi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div id="form-tujuan-baru" class="hilang cc">
                    <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                        <label class="form-label" for="nama_instansi">Nama Instansi</label>
                        <input type="text" id="nama_instansi" class="form-control" placeholder="Nama Instansi"
                            name="nama_instansi" value="{{ old('nama_instansi', $data->instansi->nama_instansi ?? '') }}">
                    </div>
                    <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                        <label class="form-label" for="nama_pengirim">Nama Tujuan</label>
                        <input type="text" id="nama_pengirim" class="form-control" placeholder="Nama Tujuan"
                            name="nama_pengirim" value="{{ old('nama_pengirim', $data->instansi->nama_pengirim ?? '') }}">
                    </div>
                    <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                        <label class="form-label" for="jabatan_pengirim">Jabatan Tujuan</label>
                        <input class="form-control" type="text" id="jabatan_pengirim" name="jabatan_pengirim"
                            placeholder="Jabatan Tujuan"
                            value="{{ old('jabatan_pengirim', $data->instansi->jabatan_pengirim ?? '') }}">
                    </div>

                    <div class="col-md-12 form-control-validation fv-plugins-icon-container">
                        <label class="form-label" for="alamat">Alamat Tujuan</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="2"
                            placeholder="Masukkan alamat di sini ....">{{ old('alamat', $data->instansi->alamat ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Personal Info -->

                <div class="col-12">
                    <h6 class="mt-2">2. Detail Isi Surat</h6>
                    <hr class="mt-0">
                </div>
                {{-- <div class="col-md-4 col-12 mb-6">
                    <label for="flatpickr-date" class="form-label">Tanggal Surat</label>
                    <input type="date" name="tanggal_srt" class="form-control" placeholder="01-01-2001"
                        id="tanggal_srt" />
                </div> --}}
                <div class="col-md-6 form-control-validation fv-plugins-icon-container">
                    <label class="form-label">Pengaju</label>
                    <input type="text" class="form-control" name="pengaju"
                        value="{{ old('pengaju', $data->pengaju ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label for="jenis_srt" class="form-label">Jenis Surat</label>
                    <select id="jenis_srt" name="jenis_srt" class="form-select">
                        <option disabled selected>Pilih Salah Satu</option>
                        @foreach ($jenisSuratOptions as $option)
                            <option value="{{ $option }}"
                                {{ old('jenis_srt', $data->jenis_srt ?? '') == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="validatorSelect" class="form-label">Validator</label>
                    <select id="validatorSelect" name="validator_id" class="form-select">
                        <option disabled selected>Pilih Salah Satu</option>
                        @foreach ($validator as $validator)
                            <option value="{{ $validator->id }}"
                                {{ old('validator_id', $data->validator_id ?? '') == $validator->id ? 'selected' : '' }}>
                                {{ $validator->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="agenda" class="form-label">Jenis Agenda</label>
                    <select id="agenda" name="agenda_id" class="form-select">
                        <option>Pilih Salah Satu</option>
                        @foreach ($agenda as $agenda)
                            <option value="{{ $agenda->id_agenda }}"
                                {{ old('agenda', $data->agenda_id ?? '') == $agenda->id_agenda ? 'selected' : '' }}>
                                {{ $agenda->nama_bagian }}
                            </option>
                            {{-- <option value="{{ $agenda->id_agenda }}">{{ $agenda->nama_bagian }}</option> --}}
                        @endforeach
                    </select>
                </div>
                {{-- Perihal --}}
                <div class="col-md-12">
                    <label class="form-label" for="perihal">Catatan</label>
                    <textarea class="form-control" name="perihal" id="perihal" cols="30" rows="2">{{ old('perihal', $data->perihal ?? '') }}</textarea>
                </div>
                @if (isset($data) && $data->file_draft)
                    <div class="mt-2">
                        <p>File saat ini:</p>
                        <iframe src="{{ asset($data->file_draft) }}" width="100%" height="600px" style="border: none;">
                        </iframe>
                    </div>
                @endif

                {{-- File Surat --}}
                <div class="col-md-12">
                    <label class="form-label" for="file_draft">File Draft Surat Keluar</label>
                    <input class="form-control" type="file" name="file_draft" id="file_draft">
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
        $('#tujuan').on('change', function() {

            const select = document.getElementById('tujuan');
            const formBaru = document.getElementById('form-tujuan-baru');
            if (select.value === 'new') {
                // Tampilkan form baru

                formBaru.classList.remove('hilang');
                formBaru.classList.add('row');

                // Kosongkan input tersembunyi
                document.getElementById('nama_instansi').value = '';
                document.getElementById('nama_pengirim').value = '';
                document.getElementById('jabatan_pengirim').value = '';
                document.getElementById('alamat').value = '';
            } else {
                // Sembunyikan form baru
                formBaru.classList.add('hilang');
                formBaru.classList.remove('row');
            }
        });
    </script>
@endpush
