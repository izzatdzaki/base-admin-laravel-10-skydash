<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamedisPendamping extends Model
{
    use HasFactory;

    protected $table = 'paramedis_pendamping';

    protected $fillable = [
        'kode_tarif',
        'nama_pendamping',
        'ruang_unit'
    ];
}
