<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agenda extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'agenda';

    /**
     * Kunci utama tabel.
     *
     * @var string
     */
    protected $primaryKey = 'id_agenda';

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
        'id_agenda',
        'id_agenda',
        'kode_bagian',
        'nama_bagian',
    ];
}
