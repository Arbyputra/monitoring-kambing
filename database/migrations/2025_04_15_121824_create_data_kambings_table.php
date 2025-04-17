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
        Schema::create('data_kambing', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->enum('jenis_kelamin', ['jantan', 'betina']);
            $table->integer('perkiraan_umur');
            $table->string('warna_bulu');
            $table->float('berat_terakhir');
            $table->text('riwayat_berat')->nullable();
            $table->float('average_gain')->nullable();
            $table->string('riwayat_kepemilikan')->nullable();
            $table->enum('status_vaksinasi', ['sudah', 'belum'])->default('belum');
            $table->text('riwayat_vaksinasi')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kambing');
    }
};
