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
        Schema::create('t_user_test_tulis', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->foreignId('asesi_id')->constrained('m_asesi')->cascadeOnDelete();
            $table->foreignId('unit_kompetensi_id')->constrained('m_unit_kompetensi')->cascadeOnDelete();
            $table->foreignId('asesor_id')->constrained('m_asesor')->cascadeOnDelete();
            $table->foreignId('skema_id')->constrained('m_skema')->cascadeOnDelete();
            $table->foreignId('test_tulis_id')->constrained('m_test_tulis')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_user_test_tulis');
    }
};
