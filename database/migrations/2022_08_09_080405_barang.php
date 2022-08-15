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
        Schema::create('barang', function(Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang');
            $table->string('merk_barang');
            $table->integer('harga_barang')->nullable();
            $table->integer('tahun_beli');
            $table->string('kondisi_barang')->nullable();
            $table->integer('stok_barang')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
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
