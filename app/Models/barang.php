<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    //use HasFactory;
    protected $table = 'barang';
    protected $primaryKeym= 'id';
    protected $fillable = ['kode_barang', 'nama_barang', 'merk_barang', 'harga_barang', 'tahun_beli', 'kondisi_barang', 'stok_barang', 'harga_barang', 'kondisi_barang', 'stok_barang','created_at', 'updated_at'];
}
