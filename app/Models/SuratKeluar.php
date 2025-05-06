<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';
    protected $primaryKey = 'id_sk';

    protected $fillable = [
        'pengaju',
        'tujuan',
        'jenis_srt',
        'validator_id',
        'agenda_id',
        'nomor_urut',
        'file_draft',
        'file_fiks',
        'status_validasi',
        'catatan_revisi',
        'tanggal_srt',
        'perihal',
        'is_read',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'tujuan', 'id_instansi');
    }
    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id', 'id');
    }
    public function agenda(): BelongsTo
    {
        return $this->belongsTo(Agenda::class, 'agenda_id', 'id_agenda');
    }
}
