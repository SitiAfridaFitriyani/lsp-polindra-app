<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasPemohon extends Model
{
    use HasFactory;
    protected $table = 'm_berkas_pemohon', $guarded = ['id'];
}
