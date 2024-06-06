<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class TestTulis extends Model
{
    use HasFactory;
    protected $table = 'm_test_tulis', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function userTestTulis()
    {
        return $this->hasOne(UserTestTulis::class, 'test_tulis_id');
    }
}
