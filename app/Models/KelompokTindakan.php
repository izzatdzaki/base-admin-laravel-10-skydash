<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokTindakan extends Model
{
    use HasFactory;

    protected $table = 'kelompok_tindakan';

    protected $fillable = [
        'kode_tindakan',
        'kode_tarif',
        'instalasi_induk',
        'instansi_pelaksana',
        'unit',
        'kelompok_tindakan',
        'detail_tindakan',
        'rincian_tindakan'
    ];
}
