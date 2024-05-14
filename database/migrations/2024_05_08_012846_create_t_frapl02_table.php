<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_frapl02', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->json('assesmen_mandiri');
            $table->enum('status_rekomendasi',['Assesment Dapat Dilanjutkan','Assesment Tidak Dapat Dilanjutkan']);
            $table->string('ttd_asesor');
            $table->string('ttd_asesi');
            $table->timestamp('tgl_ttd_asesor');
            $table->timestamp('tgl_ttd_asesi');
            $table->foreignId('skema_id')->constrained('m_skema')->cascadeOnDelete();
            $table->foreignId('asesi_id')->constrained('m_asesi')->cascadeOnDelete();
            $table->foreignId('asesor_id')->constrained('m_asesor')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_frapl02');
    }
};
