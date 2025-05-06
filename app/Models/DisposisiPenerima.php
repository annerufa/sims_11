<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DisposisiPenerima extends Pivot
{
    protected $table = 'disposisi_penerima';

    protected $casts = [
        'status_baca' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $fillable = [
        'disposisi_id',
        'user_id',
        'status_baca',
        'catatan_balasan'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function disposisi()
    {
        return $this->belongsTo(Disposisi::class);
    }
}
