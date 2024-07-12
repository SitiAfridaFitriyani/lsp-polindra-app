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
        Schema::create('t_user_test_praktek', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->longText('jawaban');
            $table->json('file')->nullable();
            $table->foreignId('asesi_id')->constrained('m_asesi')->cascadeOnDelete();
            $table->foreignId('kelompok_asesor_id')->constrained('t_kelompok_asesor')->cascadeOnDelete();
            $table->foreignId('test_praktek_id')->constrained('m_test_praktek')->cascadeOnDelete();
            $table->string('no_reg')->nullable();
            $table->string('catatan')->nullable();
            $table->string('ttd_asesor')->nullable();
            $table->string('ttd_asesi');
            $table->timestamp('tgl_ttd_asesor')->nullable();
            $table->timestamp('tgl_ttd_asesi');
            $table->enum('status_rekomendasi',['Pending','Assesment Dapat Dilanjutkan','Assesment Tidak Dapat Dilanjutkan'])->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_user_test_praktek');
    }
};
