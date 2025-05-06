<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';
    protected $primaryKey = 'id_disposisi';
    protected $fillable = [
        'surat_masuk_id',
        'perintah',
        'catatan',
        'tanggal_disposisi',
    ];

    // Relasi ke SuratMasuk
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id', 'id_sm');
    }

    // Relasi many-to-many ke User (Penerima Disposisi)
    public function penerimas()
    {
        return $this->belongsToMany(User::class, 'disposisi_penerima', 'disposisi_id', 'user_id')
            ->withPivot(['status_tugas', 'catatan_balasan', 'created_at', 'updated_at']);
    }
    //     public function disposisiPenerima()
    // {
    //     return $this->hasMany(DisposisiPenerima::class, 'disposisi_id');
    // }

    // Relasi ke surat masuk
    // public function suratMasuk()
    // {
    //     return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id', 'id_sm');
    // }

    // Relasi ke user penerima (many-to-many)
    // public function penerima()
    // {
    //     return $this->belongsToMany(User::class, 'disposisi_penerima', 'disposisi_id', 'user_id')
    //         ->withPivot('status_tugas', 'catatan_balasan')
    //         ->withTimestamps();
    // }
    // public function penerimas()
    // {
    //     return $this->hasMany(DisposisiPenerima::class, 'disposisi_id');
    // }

    // Pengirim disposisi
    public function dariUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
