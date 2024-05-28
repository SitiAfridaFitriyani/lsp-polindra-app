<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Skema extends Model
{
    use HasFactory;
    protected $table = 'm_skema', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id'); // Many To One
    }
}
