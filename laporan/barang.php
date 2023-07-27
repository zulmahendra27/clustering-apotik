<div class="card text-dark text-center">
  <div class="card-title mt-5 mb-0">
    <h2 class="font-weight-bold mb-1">Laporan Produk</h2>
    <h2 class="font-weight-bold">Apotik Madya</h2>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped" style="width: 100%;">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Stok</th>
          <th class="text-center">Harga</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $queryBarang = select($c, 'barang');

        if ($queryBarang->num_rows > 0) :
          $i = 1;
          foreach ($queryBarang as $barang) :
        ?>
            <tr>
              <td><?= $i ?></td>
              <td class="text-left"><?= $barang['nama_barang'] ?></td>
              <td><?= $barang['stok'] ?></td>
              <td class="text-center"><?= $barang['harga'] ?></td>
            </tr>
        <?php $i++;
          endforeach;
        endif; ?>
      </tbody>
    </table>
  </div>
</div>