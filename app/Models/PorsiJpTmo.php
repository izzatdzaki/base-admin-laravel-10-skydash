<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PorsiJpTmo extends Model
{
    use HasFactory;

    protected $table = 'porsi_jp_tmo';

    protected $fillable = [
        'kode',
        'jenis_tmo',
        'penerima_jp',
        'porsi_jp'
    ];

    protected $casts = [
        'porsi_jp' => 'decimal:2'
    ];
}
