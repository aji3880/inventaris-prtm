@extends('dashboard.layout.main')
@section('container')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Tambah</strong> Item
                        </div>
                        <div class="card-body card-block">
                            <form action="/barang" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="numeric" class=" form-control-label">Kode Barang</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="numeric" id="kode_barang" name="kode_barang" placeholder="Kode Barang" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Nama Barang</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="nama_barang" name="nama_barang" placeholder="Nama Barang" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class=" form-control-label">Merk Barang</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="merk_barang" name="merk_barang" placeholder="Merk Barang" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="numeric" type="number" class="form-control-label">Harga Barang</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="numeric" id="harga_barang" name="harga_barang" placeholder="Harga Barang" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="select" class=" form-control-label">Kondisi Barang</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="kondisi_barang" id="kondisi_barang" class="form-control" aria-placeholder="Silahkan Pilih" >
                                            <option value="Baik">Baik</option>
                                            <option value="Rusak">Rusak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="numeric" class=" form-control-label">Stok Barang</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="numeric" id="stok_barang" name="stok_barang" placeholder="Stok Barang" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="numeric" class=" form-control-label">Tahun Beli</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="numeric" id="tahun_beli" name="tahun_beli" placeholder="Tahun Beli" class="form-control">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-dot-circle-o"></i> Submit
                                    </button>
                                    <button type="reset" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        <p>Copyright © 2022 PERTAMINA RU VI BALONGAN.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--script>
    const kode = document.querySelector('#kode_barang');
    const nama = document.querySelector('#nama_barang');
    const harga = document.querySelector('#harga_barang');
    const kondisi = document.querySelector('#kondisi_barang');
    const stok = document.querySelector('#stok_barang');

    title.addEventListener('change', function(){
        fetch('/createBarang=' +)
    })
</script-->
@endsection
