<?php

namespace App\Http\Controllers;

use App\Models\keluar;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.keluar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\keluar  $keluar
     * @return \Illuminate\Http\Response
     */
    public function show(keluar $keluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\keluar  $keluar
     * @return \Illuminate\Http\Response
     */
    public function edit(keluar $keluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\keluar  $keluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, keluar $keluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\keluar  $keluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(keluar $keluar)
    {
        //
    }
}
