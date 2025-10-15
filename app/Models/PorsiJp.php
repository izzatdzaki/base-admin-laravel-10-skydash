<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PorsiJp extends Model
{
    use HasFactory;

    protected $table = 'porsi_jp';

    protected $fillable = [
        'kode_tarif',
        'instalasi_induk',
        'instansi_pelaksana',
        'kelompok_tindakan',
        'jlp',
        'jla',
        'jtl_st',
        'jtl_p'
    ];

    protected $casts = [
        'jlp' => 'integer',
        'jla' => 'integer',
        'jtl_st' => 'integer',
        'jtl_p' => 'integer'
    ];
}
