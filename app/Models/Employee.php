<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'tanggal_lahir',
        'alamat',
        'tanggal_masuk',
        'status',
        'jabatan_id',
        'departemen_id',
    ];

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
