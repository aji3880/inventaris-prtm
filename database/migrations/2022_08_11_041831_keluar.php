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
        Schema::create('keluar', function(Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal_keluar')->default(now());
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang');
            $table->integer('jumlah_barang_keluar')->nullable();
            $table->integer('harga_barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
