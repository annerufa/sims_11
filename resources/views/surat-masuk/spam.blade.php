$('#nama_instansi').on('change', function() {
let idInstansi = $(this).val();

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
