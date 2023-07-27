<style>
table tr {
  white-space: nowrap;
}

.bg-new-success {
  background-color: #98EECC;
}

.bg-new-info {
  background-color: #E3F6FF;
}
</style>
<div class="card">

  <div class="card-body">
    <h5>Masukkan Nilai Centroid Awal</h5>
    <div class="row">
      <div class="col-lg-4 px-2">
        <form action="" method="post">
          <table class="table table-striped table-bordered text-center mb-2" width="100%">
            <tr>
              <th class="nowrap">Data Input</th>
              <th>X</th>
              <th>Y</th>
            </tr>
            <tr>
              <th>Cluster 1</th>
              <th>
                <input type="number" name="C1X" id="C1X" class="form-control input-sm"
                  value="<?= $_POST['C1X'] ?? mt_rand(1, 99) ?>">
              </th>
              <th>
                <input type="number" name="C1Y" id="C1Y" class="form-control input-sm"
                  value="<?= $_POST['C1Y'] ?? mt_rand(1, 99) ?>">
              </th>
            </tr>
            <tr>
              <th>Cluster 2</th>
              <th>
                <input type="number" name="C2X" id="C2X" class="form-control input-sm"
                  value="<?= $_POST['C2X'] ?? mt_rand(1, 99) ?>">
              </th>
              <th>
                <input type="number" name="C2Y" id="C2Y" class="form-control input-sm"
                  value="<?= $_POST['C2Y'] ?? mt_rand(1, 99) ?>">
              </th>
            </tr>
          </table>
          <small class="text-danger">Angka yg ada di inputan merupakan nilai random.<br>Anda bisa mengubahnya
            sesuai
            keinginan.</small>
          <div class="form-group mt-3">
            <button type="submit" name="hitung" class="btn btn-flat btn-addon btn-sm btn-info">
              <i class="ti-settings"></i> Hitung
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php
  if (isset($_POST['hitung'])) :
    $c1x = mysqli_escape_string($c, htmlspecialchars($_POST['C1X']));
    $c1y = mysqli_escape_string($c, htmlspecialchars($_POST['C1Y']));
    $c2x = mysqli_escape_string($c, htmlspecialchars($_POST['C2X']));
    $c2y = mysqli_escape_string($c, htmlspecialchars($_POST['C2Y']));

    $iterasi = 20;

    $dataLog = [
      'c1x' => $c1x,
      'c1y' => $c1y,
      'c2x' => $c2x,
      'c2y' => $c2y,
    ];

    $c->query("TRUNCATE TABLE hasil");
    insert($c, $dataLog, 'log');
    $id_log = mysqli_insert_id($c);

    $joinDataset = "INNER JOIN barang b ON a.id_barang=b.id_barang";
    $queryDataset = select($c, 'dataset a', ['join' => $joinDataset]);
  ?>
  <hr class="border-dark mt-0">
  <h5 class="mt-3">Daftar Barang</h5>
  <div class="table-responsive">
    <table class="table table-striped table-bordered dt-responsive nowrap perhitungan" style="width:100%">
      <thead class="text-center">
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Stok</th>
          <th>Penjualan</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if ($queryDataset->num_rows > 0) :
            $i = 1;
            foreach ($queryDataset as $dataset) :
          ?>
        <tr>
          <td class="text-center"><?= $i ?></td>
          <td><?= $dataset['nama_barang'] ?></td>
          <td class="text-center"><?= $dataset['all_stok'] ?></td>
          <td class="text-center"><?= $dataset['penjualan'] ?></td>
        </tr>
        <?php $i++;
            endforeach;
          endif; ?>
      </tbody>
    </table>
  </div>

  <?php $oldArrayKelompok = [];
    for ($j = 0; $j < $iterasi; $j++) : ?>

  <hr class="border-dark mt-4">
  <h5 class="mt-2">Iterasi - <?= $j + 1 ?></h5>
  <div class="table-responsive mt-3">
    <table class="table table-striped table-bordered dt-responsive nowrap perhitungan" width="100%">
      <thead>
        <tr class="text-center">
          <th>No</th>
          <th>Nama Barang</th>
          <th>C1</th>
          <th>C2</th>
          <th>Jarak Terdekat</th>
          <th>Kelompok Data</th>
        </tr>
      </thead>
      <tbody>
        <?php
            $arrayC1X = [];
            $arrayC1Y = [];
            $arrayC2X = [];
            $arrayC2Y = [];

            if ($queryDataset->num_rows > 0) :
              $i = 1;
              $countC1 = 0;
              $countC2 = 0;
              $arrayKelompok = [];

              foreach ($queryDataset as $key => $dataset) :
                $class = '';
                $text = 'text-dark';

                $c1 = sqrt(pow(($dataset['all_stok'] - $c1x), 2) + pow(($dataset['penjualan'] - $c1y), 2));
                $c2 = sqrt(pow(($dataset['all_stok'] - $c2x), 2) + pow(($dataset['penjualan'] - $c2y), 2));

                $dataC[$key] = [$c1, $c2];
                // $dataC[$key][1] = $c2;

                if ($c1 < $c2) {
                  $arrayC1X[] = $dataset['all_stok'];
                  $arrayC1Y[] = $dataset['penjualan'];
                  $jarak = $c1;
                  $kelompok = 'C1';
                  $countC1++;
                  if ($j > 0) {
                    $text = 'text-white';
                    $class = 'bg-success';
                  }
                } else {
                  $arrayC2X[] = $dataset['all_stok'];
                  $arrayC2Y[] = $dataset['penjualan'];
                  $jarak = $c2;
                  $kelompok = 'C2';
                  $countC2++;
                  $text = 'text-dark';
                  $class = '';
                }

                $arrayKelompok[] = $kelompok;
            ?>
        <tr class="<?= $class ?>">
          <td class="text-center <?= $text ?>"><?= $i ?></td>
          <td class="<?= $text ?>"><?= $dataset['nama_barang'] ?></td>
          <td class="text-center <?= $text ?>"><?= $c1 ?></td>
          <td class="text-center <?= $text ?>"><?= $c2 ?></td>
          <td class="text-center <?= $text ?>"><?= $jarak ?></td>
          <td class="text-center <?= $text ?>"><?= $kelompok ?></td>
        </tr>
        <?php $i++;
              endforeach;

              $array1 = array_values($arrayKelompok);
              $array2 = array_values($oldArrayKelompok);

              // Membandingkan elemen-elemen array satu per satu
              $isSame = true;
              if (count($array1) === count($array2)) {
                for ($i = 0; $i < count($array1); $i++) {
                  if ($array1[$i] !== $array2[$i]) {
                    $isSame = false;
                    break;
                  }
                }
              } else {
                $isSame = false;
              }

            endif;

            $c1x = array_sum($arrayC1X) / $countC1;
            $c1y = array_sum($arrayC1Y) / $countC1;
            $c2x = array_sum($arrayC2X) / $countC2;
            $c2y = array_sum($arrayC2Y) / $countC2;
            ?>
      </tbody>
    </table>
  </div>

  <?php if ($isSame) : ?>
  <div class="card bg-warning">
    <div class="card-title text-center">
      <h5 class="mb-0">ITERASI BERHENTI</h5>
    </div>
  </div>
  <?php
        break;
      endif;

      if ($j > 0) {
        $oldArrayKelompok = $arrayKelompok;
      }

      if (!$isSame) :
      ?>

  <hr class="border-dark mt-4">
  <div class="card-body mt-3">
    <h5>Centroid Baru Iterasi <?= $j + 2 ?></h5>
    <div class="row">
      <div class="col-lg-4 px-2">
        <table class="table table-striped table-bordered text-center mb-2" width="100%">
          <tr>
            <th class="nowrap">Centroid</th>
            <th>X</th>
            <th>Y</th>
          </tr>
          <tr>
            <th>Cluster 1</th>
            <th><?= $c1x ?></th>
            <th><?= $c1y ?></th>
          </tr>
          <tr>
            <th>Cluster 2</th>
            <th><?= $c2x ?></th>
            <th><?= $c2y ?></th>
          </tr>
        </table>

      </div>
    </div>
  </div>

  <?php
      endif;
    endfor; ?>
  <hr class="border-dark mt-4">
  <div class="card-body mt-2">
    <h5>Kelompok Data Iterasi <?= $j ?> dan <?= $j + 1 ?></h5>
    <div class="table-responsive mt-4">
      <table class="table table-bordered dt-responsive nowrap" width="100%" style="border: 1px solid grey;">
        <thead class="text-center">
          <th>No</th>
          <th>Barang</th>
          <th>Stok</th>
          <th>Penjualan</th>
          <th>Iterasi <?= $j ?></th>
          <th class="text-center">Iterasi <?= $j + 1 ?></th>
        </thead>
        <tbody class="text-center">
          <?php
            if ($queryDataset->num_rows > 0) :
              $dataHasil['key'] = ['id_log', 'id_barang', 'c1', 'c2', 'hasil_stok', 'hasil_jual'];
              $dataHasil['values'] = [];

              foreach ($queryDataset as $key => $dataset) :
                $dataHasil['values'][$key] = [$id_log, $dataset['id_barang'], $dataC[$key][0], $dataC[$key][1], $dataset['all_stok'], $dataset['penjualan']];

                $text = 'text-dark font-weight-bold';
                if ($arrayKelompok[$key] == 'C1') {
                  $class = 'bg-new-success';
                  // $text = 'text-white';
                } else {
                  $class = 'bg-new-info';
                }
            ?>
          <tr class="<?= $class ?>">
            <th class="<?= $text ?>"><?= $key + 1 ?></th>
            <th class="<?= $text ?>"><?= $dataset['nama_barang'] ?></th>
            <th class="<?= $text ?>"><?= $dataset['all_stok'] ?></th>
            <th class="<?= $text ?>"><?= $dataset['penjualan'] ?></th>
            <th class="<?= $text ?>"><?= $oldArrayKelompok[$key] ?></th>
            <th class="<?= $text ?>"><?= $arrayKelompok[$key] ?></th>
          </tr>
          <?php endforeach;
              insert_batch($c, $dataHasil, 'hasil');
            endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <hr class="border-dark mt-4">

  <h5>Hasil Akhir</h5>
  <div class="card bg-new-info">
    <div class="card-title">
      <h5 class="text-dark">Berdasarkan hasil kelompok data pada <span class="font-weight-bold">Iterasi
          <?= $j ?></span>
        dan <span class="font-weight-bold">Iterasi <?= $j + 1 ?></span>, dimana memiliki kelompok data yang sama, maka
        proses iterasi akan dihentikan.<br> Hasil akhir <span class="font-weight-bold">Proses K-Means</span> dapat
        dilihat
        pada tabel di atas, dimana baris yang ditandai dengan warna biru tergolong laris.</h5>
    </div>
  </div>

  <?php
  else :
    $queryLog = select($c, 'log', ['order' => "id_log DESC", 'limit' => 1]);
    $dataLog = mysqli_fetch_assoc($queryLog);
  ?>

  <hr class="border-dark">

  <div class="card-body">
    <h5 class="mt-3 mb-0">Hasil K-Means Terakhir</h5>
    <small class="text-danger">Hasil pada tabel di bawah ini merupakan hasil K-Means terakhir yang diproses pada Tanggal
      <?= date('d-m-Y', strtotime($dataLog['log_time'])) ?> Jam <?= date('H:i', strtotime($dataLog['log_time'])) ?>.<br>
      Jika ingin melakukan perhitungan ulang, silahkan isi nilai Centroid Awal pada inputan di atas, kemudian tekan
      tombol Hitung.</small>

    <h5 class="mt-3">Centroid Awal</h5>
    <div class="row mb-2">
      <div class="col-lg-4 px-2">
        <table class="table table-striped table-bordered text-center mb-2" width="100%">
          <tr>
            <th class="nowrap">Centroid</th>
            <th>X</th>
            <th>Y</th>
          </tr>
          <tr>
            <th>Cluster 1</th>
            <th><?= $dataLog['c1x'] ?></th>
            <th><?= $dataLog['c1y'] ?></th>
          </tr>
          <tr>
            <th>Cluster 2</th>
            <th><?= $dataLog['c2x'] ?></th>
            <th><?= $dataLog['c2y'] ?></th>
          </tr>
        </table>

      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered dt-responsive nowrap perhitungan" width="100%">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Barang</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Penjualan</th>
            <th class="text-center">C1</th>
            <th class="text-center">C2</th>
            <th class="text-center">Kelompok Data</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
            $joinHasil = "INNER JOIN barang b ON a.id_barang=b.id_barang";
            $queryHasil = select($c, 'hasil a', ['join' => $joinHasil]);

            if ($queryHasil->num_rows > 0) :
              $i = 1;
              foreach ($queryHasil as $hasil) :
                $text = 'text-dark font-weight-bold';
                if ($hasil['c1'] < $hasil['c2']) {
                  $class = 'bg-new-success';
                  // $text = 'text-white';
                } else {
                  $class = 'bg-new-info';
                }
            ?>

          <tr>
            <td class="<?= $class . ' ' . $text ?>"><?= $i ?></td>
            <td class="text-left <?= $class . ' ' . $text ?>"><?= $hasil['nama_barang'] ?></td>
            <td class="<?= $class . ' ' . $text ?>"><?= $hasil['hasil_stok'] ?></td>
            <td class="<?= $class . ' ' . $text ?>"><?= $hasil['hasil_jual'] ?></td>
            <td class="<?= $class . ' ' . $text ?>"><?= $hasil['c1'] ?></td>
            <td class="<?= $class . ' ' . $text ?>"><?= $hasil['c2'] ?></td>
            <td class="text-center <?= $class . ' ' . $text ?>"><?= $hasil['c1'] < $hasil['c2'] ? 'C1' : 'C2' ?></td>
          </tr>

          <?php $i++;
              endforeach;
            endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php endif; ?>

</div>
<!-- /# card -->