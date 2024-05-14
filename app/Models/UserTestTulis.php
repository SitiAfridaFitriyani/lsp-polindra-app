<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTestTulis extends Model
{
    use HasFactory;
    protected $table = 't_user_test_tulis', $guarded = ['id'];
}
