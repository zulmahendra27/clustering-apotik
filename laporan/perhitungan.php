<div class="card text-dark text-center">
  <div class="card-title mt-5 mb-0">
    <h2 class="font-weight-bold mb-1">Laporan Clustering Fuzzy C-Means</h2>
    <h2 class="font-weight-bold">Apotik Madya</h2>
  </div>
  <div class="card-body pt-1">
    <?php
    $queryLog = select($c, 'log', ['order' => "id_log DESC", 'limit' => 1]);
    $dataLog = mysqli_fetch_assoc($queryLog);
    ?>

    <h6 class="mb-1">Tanggal Pemrosesan</h6>
    <p class="fw-bold"><?= date('d-m-Y H:i', strtotime($dataLog['log_time'])) ?></p>

    <h5 class="mt-3" style="text-align: left;">Parameter</h5>
    <table style="text-align: left; width: 50%;" class="table table-bordered">
      <tr>
        <th>Jumlah Cluster</th>
        <td><?= $dataLog['jumlah_cluster'] ?></td>
      </tr>
      <tr>
        <th>Max Iterasi</th>
        <td><?= $dataLog['max_iterasi'] ?></td>
      </tr>
      <tr>
        <th>Pembobot</th>
        <td><?= $dataLog['pembobot'] ?></td>
      </tr>
      <tr>
        <th>Epsilon</th>
        <td><?= $dataLog['epsilon'] ?></td>
      </tr>
    </table>

    <h5 class="mt-5" style="text-align: left;">Nilai Keanggotaan Akhir</h5>
    <div class="table-responsive">
      <table class="table table-striped small" width="100%">
        <thead>
          <tr>
            <th class="text-center">Alternatif</th>
            <?php
            for ($i = 0; $i < $dataLog['jumlah_cluster']; $i++) {
              echo "<th class='text-center'>C" . ($i + 1) . "</th>";
            }
            ?>
            <th class="text-center">Cluster</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php
          $joinHasil = "INNER JOIN barang b ON a.id_barang=b.id_barang";
          $queryAlternatif = select($c, 'barang');
          $queryHasil = select($c, 'hasil');

          if ($queryAlternatif->num_rows > 0) {
            $i = 1;
            foreach ($queryAlternatif as $alternatif) {
              echo "<tr><td style='text-align: left;'>" . $alternatif['nama_barang'] . "</td>";
              $arrarNilai = array();
              foreach ($queryHasil as $hasil) {
                if ($alternatif['id_barang'] == $hasil['id_barang']) {
                  echo "<td>" . $hasil['nilai'] . "</td>";
                  $arrarNilai[] = $hasil['nilai'];
                }
              }
              echo "<td>C" . (cariTerbesar($arrarNilai) + 1) . "</td></tr>";

              $i++;
            }
          } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>