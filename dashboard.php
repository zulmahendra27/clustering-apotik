<div class="card">
  <div class="row card-header">
    <div class="col-lg-4 col-md-6 col-12 mb-4">
      <div class="card">
        <div class="card-body d-flex">
          <div class="avatar flex-shrink-0" style="margin-right: 5rem; margin-top: -7px;">
            <span class="tf-icons bx bx-package text-success" style="font-size: 70px;"></span>
          </div>
          <div class="">
            <?php $queryBarang = select($c, 'barang') ?>
            <h6>Total Produk</h6>
            <h4 class="mb-0"><?= mysqli_num_rows($queryBarang) ?> pcs</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-12 mb-4">
      <div class="card">
        <div class="card-body d-flex">
          <div class="avatar flex-shrink-0" style="margin-right: 5rem; margin-top: -7px;">
            <span class="tf-icons bx bx-shopping-bag text-warning" style="font-size: 70px;"></span>
          </div>
          <div class="">
            <?php $queryPenjualan = select($c, 'dataset', ['select' => "SUM(penjualan) as penjualan"]) ?>
            <h6>Total Produk Terjual</h6>
            <h4 class="mb-0"><?= mysqli_fetch_assoc($queryPenjualan)['penjualan'] ?> pcs</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-12 mb-4">
      <div class="card">
        <div class="card-body d-flex">
          <div class="avatar flex-shrink-0" style="margin-right: 5rem; margin-top: -7px;">
            <span class="tf-icons bx bx-hdd text-danger" style="font-size: 70px;"></span>
          </div>
          <div class="">
            <?php $queryDataset = select($c, 'barang', ['select' => "SUM(stok) as jumlah_stok"]) ?>
            <h6>Total Stok Produk</h6>
            <h4 class="mb-0"><?= mysqli_fetch_assoc($queryDataset)['jumlah_stok'] ?> pcs</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-12 mb-4">
      <div class="card">
        <div class="card-body d-flex">
          <div class="avatar flex-shrink-0" style="margin-right: 5rem; margin-top: -7px;">
            <span class="tf-icons bx bx-money text-info" style="font-size: 70px;"></span>
          </div>
          <div class="">
            <?php $queryPendapatan = select($c, 'penjualan', ['select' => "SUM(total_harga) as pendapatan"]) ?>
            <h6>Total Pendapatan</h6>
            <h4 class="mb-0">Rp. <?= number_format(mysqli_fetch_assoc($queryPendapatan)['pendapatan'], 0, ',', '.') ?>
            </h4>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-12 mb-4">
      <div class="card">
        <div class="card-body d-flex">
          <div class="avatar flex-shrink-0" style="margin-right: 5rem; margin-top: -7px;">
            <span class="tf-icons bx bx-store-alt text-primary" style="font-size: 70px;"></span>
          </div>
          <div class="">
            <?php $queryTransaksi = select($c, 'penjualan') ?>
            <h6>Total Transaksi</h6>
            <h4 class="mb-0"><?= mysqli_num_rows($queryTransaksi) ?></h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>