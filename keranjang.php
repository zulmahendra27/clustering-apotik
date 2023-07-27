<div class="row">
  <div class="col-lg-8">

    <div class="card">

      <div class="card-title">Keranjang</div>
      <hr class="mt-0 mb-3">
      <form action="./control/aksi_insert.php" method="post">

        <div class="row">
          <div class="col-lg-4 px-2">
            <div class="form-group">
              <label for="barang">Pilih Barang</label>
              <select name="id_barang" id="barang" class="form-control form-control-sm" onchange="dataBarang(event)">
                <option value="-1">-- Pilih Barang --</option>
                <?php
                $queryBarang = select($c, 'barang');
                if ($queryBarang->num_rows > 0) :
                  foreach ($queryBarang as $barang) :
                ?>
                <option value="<?= $barang['id_barang'] ?>"><?= $barang['nama_barang'] ?></option>
                <?php endforeach;
                endif; ?>
              </select>
            </div>
          </div>
          <div class="col-lg-4 px-2">
            <div class="form-group">
              <label for="harga_barang">Harga Barang</label>
              <input type="number" min="500" value="0" name="harga_barang" id="harga_barang"
                class="form-control input-sm" readonly>
            </div>
          </div>
          <div class="col-lg-4 px-2">
            <div class="form-group">
              <label for="qty">Jumlah Beli</label>
              <input type="number" min="1" value="1" name="qty" id="qty" class="form-control input-sm">
            </div>
          </div>
        </div>
        <div class="form-group d-none" id="addToCartButton">
          <button type="submit" name="keranjang" class="btn btn-flat btn-addon btn-sm btn-info">
            <i class="ti-shopping-cart"></i> Masukkan ke keranjang
          </button>
        </div>

        <div class="table-responsive">
          <table id="table-data" class="table small table-striped table-bordered dt-responsive nowrap"
            style="width:100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah Beli</th>
                <th>Sub Total</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $username = $_SESSION['username'];
              $queryUser = select($c, 'user', ['where' => "username='$username'"]);
              $id_kasir = mysqli_fetch_assoc($queryUser)['id_user'];

              $joinKeranjang = "INNER JOIN barang b ON a.id_barang=b.id_barang";
              $queryKeranjang = select($c, 'keranjang a', ['join' => $joinKeranjang, 'where' => "a.id_kasir=$id_kasir"]);

              $totalHarga = 0;

              if ($queryKeranjang->num_rows > 0) :
                $i = 1;
                foreach ($queryKeranjang as $keranjang) :
                  $subTotal = $keranjang['harga_beli'] * $keranjang['qty'];
              ?>
              <tr>
                <td><?= $i ?></td>
                <td><?= $keranjang['nama_barang'] ?></td>
                <td><?= "Rp. " . number_format($keranjang['harga_beli'], 0, ',', '.') ?></td>
                <td><?= $keranjang['qty'] ?></td>
                <td><?= "Rp. " . number_format($subTotal, 0, ',', '.') ?></td>
                <td>
                  <button type="button" class="btn btn-sm btn-danger"
                    onclick="deleteData('<?= $keranjang['id_barang'] ?>')">
                    <i class="ti-trash"></i>
                  </button>
                </td>
              </tr>
              <?php $i++;
                  $totalHarga += $subTotal;
                endforeach;
              endif; ?>
            </tbody>
          </table>
        </div>

      </form>


    </div>
    <!-- /# card -->

  </div>

  <div class="col-lg-4">
    <div class="card">
      <form action="./control/aksi_insert.php" method="post">
        <div class="card-title">Data Pembeli</div>
        <hr class="mt-0 mb-3">

        <div class="form-group">
          <label for="nama_pembeli">Nama Pembeli</label>
          <input type="text" name="nama_pembeli" id="nama_pembeli" class="form-control input-sm" required>
        </div>
        <div class="form-group">
          <label for="total_harga">Total Harga</label>
          <input type="text" value="<?= $totalHarga ?>" name="total_harga" id="total_harga"
            class="form-control input-sm" readonly>
        </div>
        <?php if ($queryKeranjang->num_rows > 0) : ?>
        <div class="form-group">
          <button type="submit" name="pembelian" class="btn btn-flat btn-addon btn-sm btn-info">
            <i class="ti-shopping-cart-full"></i> Simpan Pembelian
          </button>
        </div>
        <?php endif; ?>
      </form>

    </div>
  </div>
</div>

<script>
function dataBarang(e) {
  let id = e.target.value;
  let harga = 0;
  let addToCartButton = document.getElementById('addToCartButton');

  fetch('./control/aksi_select.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
        'detail': 'barang',
        'id_barang': id
      })
    })
    .then(response => response.json())
    .then(data => {
      console.log(data);
      if (data != null) {
        harga = data.harga;
        addToCartButton.classList.remove('d-none');
        addToCartButton.classList.add('d-block');
      } else {
        addToCartButton.classList.remove('d-block');
        addToCartButton.classList.add('d-none');
      }
      document.getElementById('harga_barang').value = harga;
    })
    .catch(err => console.log(err));
}

function deleteData(id) {
  swal({
      title: "Apakah anda ingin menghapus barang ini dari keranjang?",
      text: "Anda dapat menambahkan kembali ke keranjang kapan saja.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Delete",
      closeOnConfirm: false,
    },
    function() {
      window.location = './control/aksi_delete.php?del=keranjang&id=' + id;
    }
  );
}
</script>