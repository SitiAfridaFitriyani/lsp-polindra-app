<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersetujuanKerahasiaan extends Model
{
    use HasFactory;
    protected $table = 't_persetujuan_assesmen', $guarded = ['id'];
}
