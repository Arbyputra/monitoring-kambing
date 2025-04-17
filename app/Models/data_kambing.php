<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_kambing extends Model
{
    use HasFactory;

    protected $table = 'data_kambing';
    protected $fillable = [
        'kode',
        'jenis_kelamin',
        'perkiraan_umur',
        'warna_bulu',
        'berat_terakhir',
        'riwayat_berat',
        'average_gain',
        'riwayat_kepemilikan',
        'status_vaksinasi',
        'riwayat_vaksinasi',
        'gambar'
    ];
}
