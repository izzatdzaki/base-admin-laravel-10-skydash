<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    protected $table = 'tarif';

    protected $fillable = [
        'kode_tarif',
        'kode',
        'instansi',
        'instansi_pelaksana',
        'kelompok_tindakan',
        'nama_tindakan',
        'detail_tindakan',
        'js',
        'jp',
        'tarif',
    ];

    protected $casts = [
        'js' => 'decimal:2',
        'jp' => 'decimal:2',
        'tarif' => 'decimal:2',
    ];
}