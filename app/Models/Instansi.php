<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Instansi extends Model
{
    use HasFactory;
    protected $table = 'instansi';

    /**
     * Kunci utama tabel.
     *
     * @var string
     */
    protected $primaryKey = 'id_instansi';

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
        'id_instansi',
        'nama_instansi',
        'nama_pengirim',
        'jabatan_pengirim',
        'periode_pengirim',
    ];

    public function suratMasuks()
    {
        return $this->hasMany(SuratMasuk::class, 'id_pengirim', 'id_instansi');
    }
}
