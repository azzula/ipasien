<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('id_pasien', 10);
            $table->string('nama', 64);
            $table->string('alamat', 128);
            $table->string('telepon', 32);
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('kelurahan', 32);
            $table->string('kecamatan', 32);
            $table->string('kota', 32);
            $table->string('tanggal_lahir', 32);
            $table->string('tempat_lahir', 32);
            $table->string('jenis_kelamin', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasiens');
    }
};
