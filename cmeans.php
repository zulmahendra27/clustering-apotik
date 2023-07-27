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
    <form action="" method="post">
      <div class="">
        <h5>Pilih rentang bulan yang data penjualannya ingin dilakukan klusterisasi</h5>
        <div class="row mb-4">
          <div class="col-lg-3">
            <label for="start_month" class="form-label">Dari Bulan</label>
            <select name="start_month" id="start_month" class="form-select">
              <?php for ($a = 1; $a <= 12; $a++) : ?>
              <option value="<?= $a ?>"><?= ucwords(bulanIndo($a)) ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="col-lg-3">
            <label for="end_month" class="form-label">Sampai Bulan</label>
            <select name="end_month" id="end_month" class="form-select">
              <?php for ($a = 1; $a <= 12; $a++) : ?>
              <option value="<?= $a ?>" <?= $a == 12 ? 'selected' : '' ?>><?= ucwords(bulanIndo($a)) ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
      </div>
      <h5>Masukkan Parameter Awal</h5>
      <div class="row mb-3">
        <label class="col-md-2 col-form-label" for="cluster">Jumlah Cluster</label>
        <div class="col-md-10">
          <input type="number" min="3" class="form-control" value="3" name="cluster" id="cluster" readonly />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-md-2 col-form-label" for="max_iterasi">Max Iterasi</label>
        <div class="col-md-10">
          <input type="number" class="form-control" value="100" name="max_iterasi" id="max_iterasi" />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-md-2 col-form-label" for="pembobot">Pembobot</label>
        <div class="col-md-10">
          <input type="number" class="form-control" value="3" name="pembobot" id="pembobot" />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-md-2 col-form-label" for="epsilon">Epsilon</label>
        <div class="col-md-10">
          <input type="number" step="0.000001" class="form-control" value="10.000000" name="epsilon" id="epsilon" />
        </div>
      </div>
      <div class="row justify-content-end">
        <div class="col-md-10">
          <button type="submit" name="hitung" class="btn btn-info">
            <span class="tf-icons bx bx-cog" style="margin-right: .35rem;"></span> Hitung
          </button>
        </div>
      </div>

    </form>
  </div>

  <?php if (isset($_POST['hitung'])) : ?>
  <div class="card-body fw-bold">
    <?php
      $startMonth = mysqli_escape_string($c, htmlspecialchars($_POST['start_month']));
      $endMonth = mysqli_escape_string($c, htmlspecialchars($_POST['end_month']));

      if ($startMonth > $endMonth) {
        echo "<script>alert('Bulan awal tidak boleh melebihi bulan akhir')</script>";
        echo "<script>window.location='?p=cmeans'</script>";
      }

      $selectMonthInDataset = "DISTINCT(bulan) AS bulan";
      $queryMonthInDataset = select($c, 'dataset', ['select' => $selectMonthInDataset]);

      $loopBulan = array();
      for ($a = $startMonth; $a <= $endMonth; $a++) {
        foreach ($queryMonthInDataset as $monthInDataset) {
          if ($a == $monthInDataset['bulan']) {
            $loopBulan[] = $monthInDataset['bulan'];
          }
        }
      }

      $cluster = mysqli_escape_string($c, htmlspecialchars($_POST['cluster']));
      $max_iterasi = mysqli_escape_string($c, htmlspecialchars($_POST['max_iterasi']));
      $pembobot = mysqli_escape_string($c, htmlspecialchars($_POST['pembobot']));
      $epsilon = mysqli_escape_string($c, htmlspecialchars($_POST['epsilon']));
      $jKriteria = count($loopBulan);

      $joinDataset = "LEFT JOIN barang b ON a.id_barang=b.id_barang";
      $queryDataset = select($c, 'dataset a', ['join' => $joinDataset]);
      $queryBarang = select($c, 'barang');
      $queryKeanggotaanAwal = select($c, 'keanggotaanawal');
      $alternatif = array();
      $idAlternatif = array();
      ?>

    <div class="alert alert-secondary text-dark" data-bs-toggle="collapse" data-bs-target="#dataDataset"
      aria-expanded="false" aria-controls="dataDataset" style="cursor: pointer;">Dataset</div>
    <div class="collapse" id="dataDataset">
      <div class="d-grid d-sm-flex p-3 border table-responsive">
        <table class="table table-striped small">
          <thead>
            <tr>
              <th>No</th>
              <th>Alternatif</th>
              <?php foreach ($loopBulan as $rangeBulan) : ?>
              <th><?= ucwords(bulanIndo($rangeBulan)) ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php
              if ($queryBarang->num_rows > 0) :
                $i = 1;
                $arrayDataset = array();
                foreach ($queryBarang as $keybarang => $barang) :
                  $alternatif[] = $barang['nama_barang'];
                  $idAlternatif[] = $barang['id_barang'];
              ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $barang['nama_barang'] ?></td>
              <?php
                    foreach ($loopBulan as $rangeBulan) {
                      foreach ($queryDataset as $keyZ => $dataset) {
                        if ($barang['id_barang'] == $dataset['id_barang'] && $dataset['bulan'] == $rangeBulan) {
                          echo "<td>" . $dataset['penjualan'] . "</td>";
                          $arrayDataset[$keybarang][$rangeBulan] = $dataset['penjualan'];
                          break;
                        }

                        if (($keyZ + 1) == $queryDataset->num_rows) {
                          echo "<td>0</td>";
                          $arrayDataset[$keybarang][$rangeBulan] = 0;
                        }
                      }
                    }
                    ?>
            </tr>
            <?php
                  $i++;
                endforeach;
              endif;
              ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="alert alert-secondary text-dark" data-bs-toggle="collapse" data-bs-target="#dataPerhitungan"
      aria-expanded="false" aria-controls="dataPerhitungan" style="cursor: pointer;">Perhitungan</div>
    <div class="collapse" id="dataPerhitungan">
      <div class="p-3 border text-xs">
        <?php
          $fungsiObjectiveAwal = 0;
          // $keanggotaanCluster = keanggotaanCluster($queryBarang->num_rows, $cluster);

          $keanggotaanCluster = array();
          foreach ($queryBarang as $keyA => $barang) {
            for ($i = 0; $i < $cluster; $i++) {
              foreach ($queryKeanggotaanAwal as $keanggotaanAwal) {
                if ($barang['id_barang'] == $keanggotaanAwal['id_barang'] && $i == $keanggotaanAwal['cluster']) {
                  $keanggotaanCluster[$keyA][$i] = $keanggotaanAwal['nilai_awal'];
                }
              }
            }
          }

          for ($i = 0; $i < $max_iterasi; $i++) :
          ?>
        <div class="alert alert-secondary text-dark" data-bs-toggle="collapse"
          data-bs-target="#dataIterasi-<?= $i + 1 ?>" aria-expanded="false" aria-controls="dataIterasi-<?= $i + 1 ?>"
          style="cursor: pointer;">Iterasi <?= $i + 1 ?>
        </div>
        <div class="collapse" id="dataIterasi-<?= $i + 1 ?>">
          <div class="p-3 border">
            <h6>Keanggotaan Cluster - <?= ($i + 1) ?></h6>
            <table class="table small">
              <?php
                  echo "<tr><th>Alternatif</th>";
                  for ($n = 0; $n < $cluster; $n++) {
                    echo "<th>C" . ($n + 1) . "</th>";
                  }
                  echo "</tr>";
                  foreach ($keanggotaanCluster as $keyA => $valueA) {
                    echo "<tr><td>" . ($keyA + 1) . "</td>";
                    foreach ($valueA as $keyB => $valueB) {
                      echo "<td>" . round($valueB, 3) . "</td>";
                    }
                    echo "</tr>";
                  }
                  ?>
            </table>
          </div>
          <div class="p-3 border">
            <h6>Miu Kuadrat Iterasi - <?= ($i + 1) ?></h6>
            <table class="table small">
              <?php
                  echo "<tr><th>Alternatif</th>";
                  for ($n = 0; $n < $cluster; $n++) {
                    echo "<th>C" . ($n + 1) . "</th>";
                  }
                  echo "</tr>";

                  $miuKuadrat = array();
                  $miuKuadratPerCluster = array();
                  foreach ($keanggotaanCluster as $keyA => $valueA) {
                    $miuKuadratDatasetRow = array();
                    $totalMiu = 0;
                    echo "<tr><td>" . ($keyA + 1) . "</td>";
                    foreach ($valueA as $keyB => $valueB) {
                      $hasilPangkat = pow($valueB, $pembobot);
                      $miuKuadratDatasetRow[] = $hasilPangkat;
                      $miuKuadratPerCluster[$keyB][$keyA] = $hasilPangkat;
                      echo "<td>" . round($hasilPangkat, 3) . "</td>";
                    }
                    $miuKuadrat[] = $miuKuadratDatasetRow;
                    echo "</tr>";
                  }
                  echo "<tr class='fw-bold'><td>TOTAL</td>";
                  for ($k = 0; $k < $cluster; $k++) {
                    // print_r(array_sum($miuKuadratPerCluster[$k]));
                    echo "<td>" . array_sum($miuKuadratPerCluster[$k]) . "</td>";
                  }
                  echo "</tr>";
                  ?>
            </table>
          </div>
          <?php
              $miuKriteriaXCluster = array();
              for ($j = 0; $j < $cluster; $j++) :
              ?>
          <div class="p-3 border">
            <h6>Miu Kuadrat Iterasi - <?= ($i + 1) ?>: Cluster - <?= ($j + 1) ?></h6>
            <table class="table small">
              <?php
                    echo "<tr><th>Alternatif</th>";
                    foreach ($loopBulan as $keyBulan => $rangeBulan) {
                      echo "<th>K" . ($keyBulan + 1) . "C" . ($j + 1) . "</th>";
                    }
                    echo "</tr>";
                    // echo "<tr><th>Alternatif</th><th>A1C" . ($j + 1) . "</th><th>A2C" . ($j + 1) . "</th></tr>";
                    foreach ($arrayDataset as $keyA => $valueA) {
                      echo "<tr>";
                      echo "<td>" . ($keyA + 1) . "</td>";
                      foreach ($valueA as $keyB => $valueB) {
                        $miuKriteria = $valueB * $miuKuadratPerCluster[$j][$keyA];
                        // $miuKriteriaB = $valueA['penjualan'] * $miuKuadratPerCluster[$j][$keyA];
                        $miuKriteriaXCluster[$j][$keyB][$keyA] = $miuKriteria;
                        // $miuKriteriaXCluster[$j][1][$keyA] = $miuKriteriaB;

                        echo "<td>" . round($miuKriteria, 3) . "</td>";
                        // echo "<td>" . $miuKriteriaB . "</td>";
                      }
                      echo "</tr>";
                    }
                    echo "<tr>";
                    echo "<th>TOTAL</th>";
                    foreach ($loopBulan as $rangeBulan) {
                      echo "<th>" . array_sum($miuKriteriaXCluster[$j][$rangeBulan]) . "</th>";
                    }
                    // echo "<th>" . array_sum($miuKriteriaXCluster[$j][1]) . "</th>";
                    echo "</tr>";
                    ?>
            </table>
          </div>
          <?php
              // print_r(array_sum($miuKuadratPerCluster[$j]));
              endfor;
              // print_r($miuKriteriaXCluster);
              ?>
          <div class="p-3 border">
            <h6>Pusat Cluster - <?= ($i + 1) ?></h6>
            <table class="table small">
              <?php
                  $pusatCluster = array();
                  echo "<tr><th></th>";
                  for ($j = 1; $j <= count($loopBulan); $j++) {
                    echo "<th>Kriteria " . $j . "</th>";
                  }
                  echo "</tr>";
                  for ($j = 0; $j < $cluster; $j++) {
                    // $pusatCluster[$j][0] = array_sum($miuKriteriaXCluster[$j][0]) / array_sum($miuKuadratPerCluster[$j]);
                    // $pusatCluster[$j][1] = array_sum($miuKriteriaXCluster[$j][1]) / array_sum($miuKuadratPerCluster[$j]);

                    echo "<tr>";
                    echo "<td>C" . ($j + 1) . "</td>";
                    foreach ($loopBulan as $rangeBulan) {
                      $pusatCluster[$j][$rangeBulan] = array_sum($miuKriteriaXCluster[$j][$rangeBulan]) / array_sum($miuKuadratPerCluster[$j]);
                      echo "<td>" . round($pusatCluster[$j][$rangeBulan], 3) . "</td>";
                    }

                    // echo "<td>" . $pusatCluster[$j][1] . "</td>";
                    echo "</tr>";
                  }
                  ?>
            </table>
          </div>
          <div class="p-3 border">
            <h6>Fungsi Objective - Iterasi <?= ($i + 1) ?></h6>
            <table class="table small">
              <?php
                  $fungsiObjective = array();
                  // print_r($miuKuadrat);
                  $totalFungsiObjective = array();
                  echo "<tr><th>Alternatif</th>";
                  for ($n = 0; $n < $cluster; $n++) {
                    echo "<th>C" . ($n + 1) . "</th>";
                  }
                  echo "<th>Total</th></tr>";
                  foreach ($queryBarang as $keyA => $valueA) {
                    echo "<tr><th>" . ($keyA + 1) . "</th>";
                    for ($m = 0; $m < $cluster; $m++) {
                      $powKriteria = 0;
                      foreach ($loopBulan as $keyBulan => $rangeBulan) {
                        foreach ($queryDataset as $dataset) {
                          if ($valueA['id_barang'] == $dataset['id_barang'] && $rangeBulan == $dataset['bulan']) {
                            $powKriteria += pow(($dataset['penjualan'] - $pusatCluster[$m][$rangeBulan]), 2);
                          }
                        }
                      }
                      // $objective = round(((pow(($valueA['all_stok'] - $pusatCluster[$m][0]), 2) + pow(($valueA['penjualan'] - $pusatCluster[$m][1]), 2)) * $miuKuadrat[$keyA][$m]), 6);
                      $objective = $powKriteria * $miuKuadrat[$keyA][$m];
                      $fungsiObjective[$keyA][$m] = $objective;
                      echo "<td>" . round($objective, 3) . "</td>";
                    }
                    $totalFungsiObjective[$keyA] = array_sum($fungsiObjective[$keyA]);
                    echo "<td class='bg-secondary text-white'>" . round($totalFungsiObjective[$keyA], 3) . "</td>";
                    echo "</tr>";
                  }

                  $selisih = array_sum($totalFungsiObjective) - $fungsiObjectiveAwal;

                  if ($selisih < 0) {
                    $selisih *= -1;
                  }

                  // echo array_sum($totalFungsiObjective);
                  echo "<tr class='bg-warning'><th class='text-white' colspan='" . ($cluster + 1) . "'>FUNGSI OBJEKTIF</th><th class='text-white'>" . array_sum($totalFungsiObjective) . "</th></tr>";
                  echo "<tr class='bg-warning'><th class='text-white' colspan='" . ($cluster + 1) . "'>FUNGSI OBJEKTIF SEBELUMNYA</th><th class='text-white'>" . $fungsiObjectiveAwal . "</th></tr>";
                  echo "<tr class='bg-warning'><th class='text-white' colspan='" . ($cluster + 1) . "'>SELISIH FUNGSI OBJEKTIF DENGAN FUNGSI OBJEKTIF SEBELUMNYA</th><th class='text-white'>" . $selisih . "</th></tr>";
                  ?>
            </table>
          </div>

          <?php
              // die;

              if ($selisih < $epsilon) {
                echo "<div class='alert alert-success text-dark mt-3'>Karena selisih Fungsi Objektif (" . $selisih . ") <= Epsilon (" . $epsilon . "), maka iterasi dihentikan.</div>";
                echo "</div>";
                break;
              }

              echo "<div class='alert alert-warning text-dark mt-3'>Karena selisih Fungsi Objektif (" . $selisih . ") > Epsilon (" . $epsilon . "), maka iterasi dilanjutkan.</div>";

              $fungsiObjectiveAwal = array_sum($totalFungsiObjective);

              $matriksU = array();
              $totalMatriksU = array();
              $newKeanggotaanCluster = array();
              foreach ($queryBarang as $keyA => $valueA) {
                for ($m = 0; $m < $cluster; $m++) {
                  $powMatriks = 0;
                  foreach ($loopBulan as $keyBulan => $rangeBulan) {
                    foreach ($queryDataset as $dataset) {
                      if ($valueA['id_barang'] == $dataset['id_barang'] && $rangeBulan == $dataset['bulan']) {
                        $powMatriks += pow(($dataset['penjualan'] - $pusatCluster[$m][$rangeBulan]), 2);
                      }
                    }
                  }

                  $matriks = pow($powMatriks, (-1 / ($pembobot - 1)));
                  // $matriks = round((pow((pow(($valueA['all_stok'] - $pusatCluster[$m][0]), 2) + pow(($valueA['penjualan'] - $pusatCluster[$m][1]), 2)), (-1 / ($pembobot - 1)))), 6);
                  $matriksU[$keyA][$m] = $matriks;
                }
                $totalMatriksU[$keyA] = array_sum($matriksU[$keyA]);

                for ($m = 0; $m < $cluster; $m++) {
                  $newKeanggotaanCluster[$keyA][$m] = $matriksU[$keyA][$m] / $totalMatriksU[$keyA];
                }
              }
              // echo array_sum($totalMatriksU);
              // print_r($newKeanggotaanCluster);
              $keanggotaanCluster = $newKeanggotaanCluster;
              ?>

        </div>

        <?php endfor; ?>

      </div>
    </div>

    <div class="alert alert-secondary text-dark" data-bs-toggle="collapse" data-bs-target="#dataHasil"
      aria-expanded="false" aria-controls="dataHasil" style="cursor: pointer;">Hasil</div>
    <div class="collapse show" id="dataHasil">
      <div class="p-3 border">
        <h6>Nilai Keanggotaan Akhir (Iterasi <?= ($i + 1) ?>)</h6>
        <table class="table small">
          <?php
            // print_r($keanggotaanCluster);
            echo "<tr><th>Alternatif</th>";
            for ($o = 0; $o < $cluster; $o++) {
              echo "<th>C" . ($o + 1) . "</th>";
            }
            echo "<th>Cluster</th></tr>";

            $dataLog = [
              'jumlah_cluster' => $cluster,
              'max_iterasi' => $max_iterasi,
              'pembobot' => $pembobot,
              'epsilon' => $epsilon
            ];

            insert($c, $dataLog, 'log');

            $dataHasil['key'] = ['id_barang', 'cluster', 'nilai'];
            $dataHasil['values'] = [];

            foreach ($keanggotaanCluster as $keyA => $valueA) {
              echo "<tr><td>" . $alternatif[$keyA] . "</td>";
              foreach ($valueA as $keyB => $valueB) {
                echo "<td>" . $valueB . "</td>";
                $dataHasil['values'][] = [$idAlternatif[$keyA], $keyB, $valueB];
              }
              echo "<td>C" . (cariTerbesar($valueA) + 1) . "</td></tr>";
            }

            $c->query("TRUNCATE TABLE hasil");
            insert_batch($c, $dataHasil, 'hasil');
            // print_r($dataHasil);
            ?>
        </table>
      </div>
    </div>

  </div>

  <?php
  else :
    $queryLog = select($c, 'log', ['order' => "id_log DESC", 'limit' => 1]);
    $dataLog = mysqli_fetch_assoc($queryLog);
  ?>

  <hr class="border-dark">

  <div class="card-body">
    <h5 class="mt-3 mb-0">Hasil Clustering Fuzzy C-Means Terakhir</h5>
    <small class="text-danger">Hasil pada tabel di bawah ini merupakan hasil clustering terakhir tanggal
      <?= date('d-m-Y', strtotime($dataLog['log_time'])) ?> jam <?= date('H:i', strtotime($dataLog['log_time'])) ?>.<br>
      Jika ingin melakukan perhitungan ulang, silahkan isi parameter di atas, dan tekan tombol Hitung.</small>

    <h5 class="mt-3">Parameter</h5>
    <div class="row mb-3">
      <label class="col-md-2 col-form-label" for="cluster">Jumlah Cluster</label>
      <div class="col-md-4">
        <input type="number" min="3" class="form-control" value="<?= $dataLog['jumlah_cluster'] ?>" name="cluster"
          id="cluster" disabled />
      </div>
    </div>
    <div class="row mb-3">
      <label class="col-md-2 col-form-label" for="max_iterasi">Max Iterasi</label>
      <div class="col-md-4">
        <input type="number" class="form-control" value="<?= $dataLog['max_iterasi'] ?>" name="max_iterasi"
          id="max_iterasi" disabled />
      </div>
    </div>
    <div class="row mb-3">
      <label class="col-md-2 col-form-label" for="pembobot">Pembobot</label>
      <div class="col-md-4">
        <input type="number" class="form-control" value="<?= $dataLog['pembobot'] ?>" name="pembobot" id="pembobot"
          disabled />
      </div>
    </div>
    <div class="row mb-3">
      <label class="col-md-2 col-form-label" for="epsilon">Epsilon</label>
      <div class="col-md-4">
        <input type="number" step="0.000001" class="form-control" value="<?= $dataLog['epsilon'] ?>" name="epsilon"
          id="epsilon" disabled />
      </div>
    </div>

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
                $arrayNilai = array();
                foreach ($queryHasil as $hasil) {
                  if ($alternatif['id_barang'] == $hasil['id_barang']) {
                    echo "<td>" . $hasil['nilai'] . "</td>";
                    $arrayNilai[] = $hasil['nilai'];
                  }
                }
                echo "<td>C" . (cariTerbesar($arrayNilai) + 1) . "</td></tr>";

                $i++;
              }
            } ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php endif; ?>

</div>
<!-- /# card -->