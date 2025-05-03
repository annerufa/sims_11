<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratMasuk extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'surat_masuk';

    /**
     * Kunci utama tabel.
     *
     * @var string
     */
    protected $primaryKey = 'id_sm';

    /**
     * Tipe data kunci utama.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Menunjukkan apakah kunci utama bertambah atau tidak.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Kolom yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_pengirim',
        'jenis_srt',
        'sifat_srt',
        'nomor_srt',
        'tanggal_srt',
        'tanggal_terima',
        'agenda_id',
        'nomor_urut',
        'perihal',
        'keterangan',
        'file',
        'user_id'
    ];

    /**
     * Kolom yang harus disembunyikan dari array.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Kolom yang harus di-cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_surat' => 'date:Y-m-d',
        'tanggal_terima' => 'date:Y-m-d',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi dengan model User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function disposisi()
    {
        return $this->hasMany(Disposisi::class);
    }

    /**
     * Relasi dengan model Instansi.
     */
    public function instansi(): BelongsTo
    {
        return $this->belongsTo(Instansi::class, 'id_pengirim', 'id_instansi');
    }
    /**
     * Relasi dengan model Instansi.
     */
    public function agenda(): BelongsTo
    {
        return $this->belongsTo(Agenda::class, 'agenda_id', 'id_agenda');
    }

    /**
     * Aksesor untuk URL file.
     */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file ? asset('storage/' . $this->file) : null;
    }

    /**
     * Aksesor untuk format tanggal surat.
     */
    public function getTanggalSuratFormattedAttribute(): string
    {
        return $this->tanggal_surat->format('d/m/Y');
    }

    /**
     * Aksesor untuk format tanggal terima.
     */
    public function getTanggalTerimaFormattedAttribute(): string
    {
        return $this->tanggal_terima->format('d/m/Y');
    }
}
