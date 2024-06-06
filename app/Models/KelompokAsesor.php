<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KelompokAsesor extends Model
{
    use HasFactory;
    protected $table = 't_kelompok_asesor', $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }

    public function asesor()
    {
        return $this->belongsTo(Asesor::class,'asesor_id');
    }
}
