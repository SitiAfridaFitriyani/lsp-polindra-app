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
        Schema::create('m_skema', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('kode_skema');
            $table->string('judul_skema');
            $table->string('no_skema');
            $table->enum('jenis_standar',['KKNI','Okupasi','Klaster']);
            $table->foreignId('event_id')->constrained('m_event')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_skema');
    }
};
