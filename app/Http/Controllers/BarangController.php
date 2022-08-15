<?php

namespace App\Http\Controllers;

use App\Models\barang;
use Clockwork\Request\Request as RequestRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $barang = barang::where('nama_barang', 'like', '%'.$search.'%')->paginate(10);
        //$barang = barang::select('*')->get();
        return view('dashboard.barang.index', ['barang' => $barang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.barang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $barang = barang::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'merk_barang' => $request->merk_barang,
            'stok_barang' => $request->stok_barang,
            'kondisi_barang' => $request->kondisi_barang,
            'harga_barang' => $request->harga_barang,
            'tahun_beli' => $request->tahun_beli,
        ]);

        return redirect('/barang')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(barang $barang, $id)
    {
        $barang = barang::findOrFail($id);
        return view('dashboard.barang.edit', ['barang' => $barang ]);
        //return view('dashboard.barang.edit', compact('barang'));
        /*return view('dashboard.barang.edit',[
            $barang => barang::all()
        ]);*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, barang $barang, $id)
    {
        $barang = barang::findOrFail($id);
        $barang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'merk_barang' => $request->merk_barang,
            'stok_barang' => $request->stok_barang,
            'kondisi_barang' => $request->kondisi_barang,
            'harga_barang' => $request->harga_barang,
            'tahun_beli' => $request->tahun_beli,
        ]);
        return redirect('/barang')->with('success', 'Data berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(barang $barang)
    {
        barang::destroy($barang->id);

        return redirect('/barang')->with('success', 'File  berhasil dihapus');
    }
    public function createBarang(Request $request){

    }
}
