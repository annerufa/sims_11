<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="">

        <div class="col-md-4 form-control-validation fv-plugins-icon-container">
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
        <br>
        <!-- Form untuk instansi baru (awalnya hidden) -->
        <div id="form-tujuan-baru" style="display: none;">
            <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="nama_instansi">Nama Instansi</label>
                <input type="text" id="nama_instansi" class="form-control" placeholder="Nama Instansi"
                    name="nama_instansi" value="{{ old('nama_instansi', $data->instansi->nama_instansi ?? '') }}">
            </div>
            <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="nama_pengirim">Nama Pengirim</label>
                <input type="text" id="nama_pengirim" class="form-control" placeholder="Nama Pengirim"
                    name="nama_pengirim" value="{{ old('nama_pengirim', $data->instansi->nama_pengirim ?? '') }}">
            </div>
            <div class="col-md-4 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="jabatan_pengirim">Jabatan Pengirim</label>
                <input class="form-control" type="text" id="jabatan_pengirim" name="jabatan_pengirim"
                    placeholder="Jabatan (periode)"
                    value="{{ old('jabatan_pengirim', $data->instansi->jabatan_pengirim ?? '') }}">
            </div>

            <div class="col-md-12 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="alamat">Alamat Pengirim</label>
                <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="2"
                    placeholder="Masukkan alamat di sini ....">{{ old('alamat', $data->instansi->alamat ?? '') }}</textarea>
            </div>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#tujuan').on('change', function() {

            const select = document.getElementById('tujuan');
            const formBaru = document.getElementById('form-tujuan-baru');
            if (select.value === 'new') {
                // Tampilkan form baru
                formBaru.style.display = 'block';

                // Kosongkan input tersembunyi
                document.getElementById('nama_instansi').value = '';
                document.getElementById('nama_pengirim').value = '';
                document.getElementById('jabatan_pengirim').value = '';
                document.getElementById('alamat').value = '';
            } else {
                // Sembunyikan form baru
                formBaru.style.display = 'none';
            }
        });
    </script>
</body>

</html>
