<?php if ($_GET['p'] == 'penjualan') : ?>
<div class="card">

  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="mb-0"><?= $title ?? '' ?></h5>
  </div>
  <div class="card-body table-responsive text-nowrap">
    <table id="myTable" class="table table-striped table-bordered pt-4" style="width:100%;">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Pembeli</th>
          <th>Total Pembelian</th>
          <th>Waktu</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $query = select($c, 'penjualan');
          if ($query->num_rows > 0) :
            $i = 1;
            foreach ($query as $penjualan) :
          ?>
        <tr>
          <td><?= $i ?></td>
          <td><?= $penjualan['nama_pembeli'] ?></td>
          <td>Rp. <?= number_format($penjualan['total_harga'], 0, ',', '.') ?></td>
          <td><?= date('d-m-Y H:i:s', strtotime($penjualan['waktu'])) ?></td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="?p=penjualan_detail&id=<?= $penjualan['id_penjualan'] ?>">
                  <i class="bx bx-detail me-1"></i> Detail Transaksi
                </a>
                <a class="dropdown-item" href="./laporan/struk.php?id=<?= $penjualan['id_penjualan'] ?>"
                  target="_blank">
                  <i class="bx bx-message-alt-detail me-1"></i> Struk
                </a>
              </div>
            </div>
          </td>
        </tr>
        <?php $i++;
            endforeach;
          endif; ?>
      </tbody>
    </table>
  </div>
</div>
<!-- /# card -->

<?php else : ?>

<?php
  $namaPembeli = "-";
  $totalHarga = "-";

  if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $where = "a.id_penjualan=$id";
    $join = "INNER JOIN barang b ON a.id_barang=b.id_barang INNER JOIN penjualan c ON a.id_penjualan=c.id_penjualan";
    $queryPenjualan = select($c, 'detail a', ['join' => $join, 'where' => $where]);

    if ($queryPenjualan->num_rows > 0) {
      foreach ($queryPenjualan as $data) {
        $namaPembeli = $data['nama_pembeli'];
        $totalHarga = $data['total_harga'];
        break;
      }
    }
  }
  ?>

<div class="card mb-4">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="mb-0"><?= $title ?? '' ?></h5>
    <a href="?p=penjualan" class="btn btn-xs btn-info">Kembali</a>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-2">
        <h6>Nama Pembeli</h6>
      </div>
      <div class="col-md-10">
        <h6><?= $namaPembeli ?></h6>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2">
        <h6>Total Harga</h6>
      </div>
      <div class="col-md-10">
        <h6>Rp. <?= number_format($totalHarga, 0, ',', '.') ?></h6>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-bordered" width="100%">
        <thead class="text-center">
          <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Jumlah Beli</th>
            <th>Harga Barang</th>
            <th>Sub Total</th>
          </tr>
        </thead>
        <tbody>

          <?php
            if (isset($_GET['id'])) :
              if ($queryPenjualan->num_rows > 0) :
                $i = 1;
                foreach ($queryPenjualan as $data) :
            ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= $data['nama_barang'] ?></td>
            <td><?= $data['qty'] ?></td>
            <td>Rp. <?= number_format($data['harga_barang'], 0, ',', '.') ?></td>
            <td>Rp. <?= number_format($data['qty'] * $data['harga_barang'], 0, ',', '.') ?></td>
          </tr>
          <?php
                  $i++;
                endforeach;
              else :
                echo "<tr class='text-center'><th colspan='5'>-- Tidak ada data --</th></tr>";
              endif;
            else :
              echo "<tr class='text-center'><th colspan='5'>-- Tidak ada data --</th></tr>";
            endif;
            ?>

        </tbody>
      </table>
    </div>
  </div>
</div>

<?php endif; ?>