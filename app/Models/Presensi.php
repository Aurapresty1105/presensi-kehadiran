<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    protected $table = 'presensi';
    protected $fillable = [
        'id_siswa',
        'catatan',
        'keterangan_presensi',
        'tanggal',
        'waktu_datang',
        'waktu_pulang',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
}
