<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paramedis extends Model
{
    use HasFactory;

    protected $table = 'paramedis';

    protected $fillable = [
        'kode',
        'nama_paramedis',
        'ruang_unit'
    ];
}
