<?php if ($_GET['p'] == 'dataset') : ?>
<div class="card">

  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="mb-0"><?= $title ?? '' ?></h5>
    <?php if ($_SESSION['level'] == 'admin') : ?>
    <a href="?p=dataset_add" class="btn btn-xs btn-success">Tambah Data</a>
    <?php endif; ?>
  </div>
  <div class="card-body">
    <form action="" method="post">
      <div class="d-block">
        <h5>Pilih rentang bulan untuk melihat dataset</h5>
        <div class="row mb-3">
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
        <div class="row mb-4">
          <div class="col-lg-3">
            <button type="submit" name="filter" class="btn btn-success">Filter</button>
          </div>
        </div>
      </div>
    </form>
    <?php if (isset($_POST['filter'])) : ?>
    <h6 class="text-danger">Jika ingin mengganti data pada Dataset, silahkan "DOUBLE CLICK" pada sel data, lalu tekan
      "ENTER" untuk menyimpan data.</h6>
    <div class="table-responsive">
      <table id="table-dataset" class="table table-striped small pt-4 text-nowrap" style="width:100%;">
        <?php
            $startMonth = mysqli_escape_string($c, htmlspecialchars($_POST['start_month']));
            $endMonth = mysqli_escape_string($c, htmlspecialchars($_POST['end_month']));
            // $startMonth = 2;
            // $endMonth = 5;

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

            $joinDataset = "LEFT JOIN barang b ON a.id_barang=b.id_barang";
            $queryDataset = select($c, 'dataset a', ['join' => $joinDataset]);
            $queryBarang = select($c, 'barang');
            ?>
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
                          echo "<td data-id='" . $dataset['id_barang'] . "-" . $dataset['bulan'] . "'>" . $dataset['penjualan'] . "</td>";
                          $arrayDataset[$keybarang][$rangeBulan] = $dataset['penjualan'];
                          break;
                        }

                        if (($keyZ + 1) == $queryDataset->num_rows) {
                          echo "<td data-id='" . $barang['id_barang'] . "-" . $rangeBulan . "'>0</td>";
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
    <?php endif; ?>
  </div>
</div>
<!-- /# card -->

<script>
document.addEventListener("DOMContentLoaded", function() {
  const table = document.getElementById("table-dataset");
  const cells = table.getElementsByTagName("td");

  for (let i = 0; i < cells.length; i++) {
    cells[i].addEventListener("dblclick", function() {
      editCell(this);
      // console.log(this.dataset.id);
    });
  }

  function editCell(cell) {
    // console.log(cell.dataset.id);
    const currentValue = cell.innerHTML;
    const input = document.createElement("input");
    input.type = "number";
    input.setAttribute('class', 'form-control form-control-sm col-lg-2');
    input.value = currentValue;

    input.addEventListener("keyup", function() {
      if (event.key === "Enter") {
        updateDataset(cell, this.value);
      }
    });

    // input.addEventListener("blur", function() {
    //   updateDataset(cell, this.value);
    // });

    cell.innerHTML = "";
    cell.appendChild(input);
    input.focus();
  }

  function updateDataset(cell, value) {
    cell.innerHTML = value;

    fetch('./control/aksi_update.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
          'dataset': 'dataset',
          'id': cell.dataset.id,
          'value': value
        })
      })
      .then(response => response.json())
      .then(data => {
        // console.log(data);
        if (data.status) {
          toastr.success('Dataset berhasil diupdate', 'Sukses', {
            timeOut: 2000,
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "tapToDismiss": false
          })
        } else {
          toastr.error('Gagal diupdate', 'Error', {
            "positionClass": "toast-top-right",
            timeOut: 2000,
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "tapToDismiss": false

          })
        }
      })
      .catch(err => console.log(err));
  }
});
</script>

<?php
else :
  $queryBarang = select($c, 'barang');
?>

<div class="card mb-4">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="mb-0"><?= $title ?? '' ?></h5>
    <a href="?p=dataset" class="btn btn-xs btn-info">Kembali</a>
  </div>
  <div class="card-body">
    <form action="./control/aksi_insert.php" method="post">
      <div class="row mb-4">
        <label class="col-md-2 col-form-label" for="bulan">Pilih Bulan</label>
        <div class="col-md-4">
          <select name="bulan" id="bulan" class="form-control">
            <?php for ($i = 1; $i <= 12; $i++) : ?>
            <option value="<?= $i ?>"><?= ucwords(bulanIndo($i)) ?></option>
            <?php endfor; ?>
          </select>
        </div>
      </div>

      <h6>Tambah Data Penjualan</h6>
      <div class="table-responsive mt-4">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Produk</th>
              <th>Jumlah Penjualan</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($queryBarang->num_rows > 0) : $i = 1;
                foreach ($queryBarang as $barang) : ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $barang['nama_barang'] ?></td>
              <td>
                <input type="number" min="1" value="1" name="penjualan[]" id="penjualan" class="form-control">
              </td>
            </tr>
            <?php $i++;
                endforeach;
              else : ?>
            <tr>
              <th colspan="3" class="text-center">-- Tidak ada data --</th>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <?php if ($queryBarang->num_rows > 0) : ?>
      <div class="row mt-4">
        <div class="col-md-10">
          <button type="submit" name="dataset" class="btn btn-primary">Simpan</button>
        </div>
      </div>
      <?php endif; ?>
    </form>
  </div>
</div>
<?php endif; ?>