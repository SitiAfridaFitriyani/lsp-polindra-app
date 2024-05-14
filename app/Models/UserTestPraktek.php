<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTestPraktek extends Model
{
    use HasFactory;
    protected $table = 't_user_test_praktek', $guarded = ['id'];
}
