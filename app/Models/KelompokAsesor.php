<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokAsesor extends Model
{
    use HasFactory;
    protected $table = 't_kelompok_asesor', $guarded = ['id'];
}
