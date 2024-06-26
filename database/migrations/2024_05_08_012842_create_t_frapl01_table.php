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
        Schema::create('t_frapl01', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('no_ktp',20)->unique();
            $table->string('tempat_lahir');
            $table->json('berkas_pemohon_asesi');
            $table->date('tgl_lahir');
            $table->enum('jenis_kelamin',['pria','wanita']);
            $table->string('kebangsaan',30);
            $table->text('alamat');
            $table->string('kode_pos',5);
            $table->string('no_hp',13)->unique();
            $table->string('tlp_rumah',20)->unique();
            $table->string('tlp_kantor',20)->unique();
            $table->text('alamat_kantor');
            $table->string('pendidikan',100);
            $table->string('nama_institusi');
            $table->string('no_tlp_institusi',20)->unique();
            $table->string('kode_pos_institusi',5);
            $table->string('email_institusi', 50)->unique();
            $table->string('fax',50);
            $table->string('tujuan_assesmen');
            $table->string('jabatan');
            $table->string('no_reg');
            $table->enum('status_rekomendasi',['Diterima','Tidak Diterima']);
            $table->string('ttd_admin_lsp');
            $table->string('ttd_asesi');
            $table->timestamp('tgl_ttd_admin_lsp');
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
        Schema::dropIfExists('t_frapl01');
    }
};
