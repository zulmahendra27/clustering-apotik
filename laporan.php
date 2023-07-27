<div class="card text-dark">
  <div class="card-body">
    <div class="row">

      <?php if (in_array($_SESSION['level'], ['admin', 'kasir'])) : ?>
        <div class="col-lg-3">
          <h6>Laporan Barang</h6>
          <div class="form-group">
            <a target="_blank" href="./laporan/laporan.php?p=barang" class="btn btn-flat btn-addon btn-sm btn-info btn-block">
              <i class="ti-file"></i> Cetak Laporan
            </a>
          </div>
        </div>
      <?php endif; ?>

      <div class="col-lg-3">
        <h6>Laporan Penjualan</h6>
        <div class="form-group">
          <a target="_blank" href="./laporan/laporan.php?p=penjualan" class="btn btn-flat btn-addon btn-sm btn-info btn-block">
            <i class="ti-file"></i> Cetak Laporan
          </a>
        </div>
      </div>

      <?php if (in_array($_SESSION['level'], ['admin', 'manager'])) : ?>
        <div class="col-lg-3">
          <h6>Laporan Fuzzy C-Means</h6>
          <div class="form-group">
            <a target="_blank" href="./laporan/laporan.php?p=perhitungan" class="btn btn-flat btn-addon btn-sm btn-info btn-block">
              <i class="ti-file"></i> Cetak Laporan
            </a>
          </div>
        </div>
      <?php endif; ?>

    </div>

  </div>
</div>