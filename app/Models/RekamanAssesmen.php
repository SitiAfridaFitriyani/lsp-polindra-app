<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamanAssesmen extends Model
{
    use HasFactory;
    protected $table = 't_rekaman_assesmen', $guarded = ['id'];
}
