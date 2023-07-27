<style>
  table {
    font-size: 8px;
  }

  #tableDetail tr td {
    display: table;
    border: none;
    /* padding: 0 10px; */
  }

  .table-row {
    display: table-row;
  }

  .table-cell {
    display: table-cell;
    white-space: nowrap;
    padding: 0 5px;
    height: auto;
    /* border: 1px solid black; */
  }
</style>
<div class="card text-dark text-center">
  <div class="card-title mt-5 mb-0">
    <h2 class="font-weight-bold mb-1">Laporan Data Penjualan</h2>
    <h2 class="font-weight-bold">Apotik Madya</h2>
  </div>
  <div class="card-body">
    <table class="table table-bordered small" style="width: 100%;">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Pembeli</th>
          <th>Barang yang dibeli</th>
          <th>Sub Total</th>
          <th>Total Harga</th>
          <th class="text-center">Waktu Pembelian</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $queryPenjualan = select($c, 'penjualan');

        if ($queryPenjualan->num_rows > 0) :
          $i = 1;
          foreach ($queryPenjualan as $penjualan) :
            $id_penjualan = $penjualan['id_penjualan'];
            $joinDetail = "INNER JOIN barang b ON a.id_barang=b.id_barang";
            $queryDetail = select($c, 'detail a', ['where' => "a.id_penjualan=$id_penjualan", 'join' => $joinDetail]);
        ?>
            <tr>
              <td><?= $i ?></td>
              <td class="text-left"><?= $penjualan['nama_pembeli'] ?></td>
              <td>
                <div id="tableDetail">
                  <?php
                  if ($queryDetail->num_rows > 0) :
                    foreach ($queryDetail as $detail) :
                  ?>
                      <div class="table-row">
                        <div class="table-cell" style="text-align: left;"><?= $detail['nama_barang'] ?></div>
                        <div class="table-cell">@</div>
                        <div class="table-cell" style="text-align: right;"><?= $detail['qty'] . " pcs" ?></div>
                        <div class="table-cell">x</div>
                        <div class="table-cell" style="text-align: left;">Rp.
                          <?= number_format($detail['harga_barang'], 0, ',', '.') ?></div>
                      </div>
                  <?php endforeach;
                  endif; ?>
                </div>
              </td>
              <td class="text-nowrap" style="text-align: left;">
                <?php
                if ($queryDetail->num_rows > 0) :
                  foreach ($queryDetail as $detail) :
                ?>
                    <div>Rp. <?= number_format(($detail['qty'] * $detail['harga_barang']), 0, ',', '.') ?></div>
                <?php endforeach;
                endif; ?>
              </td>
              <td class="text-nowrap">Rp. <?= number_format($penjualan['total_harga'], 0, ',', '.') ?></td>
              <td class="text-center text-nowrap"><?= date('d-m-Y H:i', strtotime($penjualan['waktu'])) ?></td>
            </tr>
        <?php
            $i++;
          endforeach;
        endif; ?>
      </tbody>
    </table>
  </div>
</div>