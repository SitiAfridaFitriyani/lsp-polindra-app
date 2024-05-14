<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestTulis extends Model
{
    use HasFactory;
    protected $table = 'm_test_tulis', $guarded = ['id'];
}
