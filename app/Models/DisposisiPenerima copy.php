<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DisposisiPenerimaCopy extends Model
{
    use HasFactory;

    protected $table = 'disposisi_penerima';
    protected $primaryKey = 'id_disposisi_penerima';

    protected $fillable = [
        'disposisi_id',
        'user_id',
        'status_tugas',
        'catatan_balasan',
    ];

    public function disposisi()
    {
        return $this->belongsTo(Disposisi::class, 'disposisi_id', 'id_disposisi');
    }
    public function disposisiDiterima()
    {
        return $this->hasMany(DisposisiPenerima::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
