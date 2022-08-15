@extends('dashboard.layout.main')
@section('container')
<div class="main-content">
    @if (session()->has('success'))
    <script>alert('{{ session()->get('success') }}')</script>
    @endif
    <div class="section__content section__content--p30 ">
        <div class="container-fluid">
            <div class="row">
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <!-- END USER DATA-->
                </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">data table</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <form class="form-header" action="" method="GET">
                                <input class="au-input au-input--xl" type="text" name="search" placeholder="Nama Barang" />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="table-data__tool-right">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small"><i class="zmdi zmdi-plus"></i><a style="color: white" href="/create">add item</a></button>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead class="table-info">
                                <tr class="table-header">
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Merk Barang</th>
                                    <th>Stok Barang</th>
                                    <th>Kondisi Barang</th>
                                    <th>Harga Barang</th>
                                    <th>Tahun Pembelian</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php $no = 1?>
                                @foreach ($barang as $barangs)
                            <tbody>
                                <tr class="tr-shadow top">
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $barangs->kode_barang }}</td>
                                    <td>{{ $barangs->nama_barang }}</td>
                                    <td>{{ $barangs->merk_barang }}</td>
                                    <td>{{ $barangs->stok_barang}}</td>
                                    <td>
                                        @if ($barangs->kondisi_barang == 'Baik')
                                        <span class="status--process">{{ $barangs->kondisi_barang }}</span>
                                        @endif
                                        @if ($barangs->kondisi_barang == 'Rusak')
                                        <span class="status--denied">{{ $barangs->kondisi_barang }}</span>
                                        @endif

                                    </td>
                                    <td>Rp {{ $barangs->harga_barang }}</td>
                                    <td>{{ $barangs->tahun_beli }}</td>
                                    <td>
                                        <div class="table-data-feature">
                                            <!--a href="" class="item" data-toggle="tooltip" data-placement="top" title="Edit" >
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Edit" href="/{id}/edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </a>
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Delete" type="submit">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button-->
                                            <a href="/{{ $barangs->id }}" data-placement="top"  data-toggle="tooltip" data-placement="top" title="Edit" >
                                            <button class="item" data-toggle="tooltip" data-placement="top">
                                                <i class="zmdi zmdi-edit"></i>
                                            </a>
                                                <form onsubmit="return confirm('Apakah Anda Yakin Ingin Menghapus?');" action="{{ route('barang.destroy', $barangs->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete" type="submit">
                                                        <i class="zmdi zmdi-delete"></i>
                                                </form>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                            @endforeach
                        </table>
                    <!-- END DATA TABLE -->
                </div>
                <br>
                <div class="col-lg-12">
                    {{ $barang->links() }}
                </div>
            </div>
            <div class="col">
                <div class="col-md-12 justify-center">
                    <div class="copyright">
                        <p>Copyright © 2022 PERTAMINA RU VI BALONGAN.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
