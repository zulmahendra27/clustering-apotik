<?php
$username = $_SESSION['username'];
$queryUser = select($c, 'user', ['where' => "username='$username'"]);
$id_kasir = mysqli_fetch_assoc($queryUser)['id_user'];

$joinKeranjang = "INNER JOIN barang b ON a.id_barang=b.id_barang";
$queryKeranjang = select($c, 'keranjang a', ['join' => $joinKeranjang, 'where' => "a.id_kasir=$id_kasir"]);

$totalHarga = 0;

if ($queryKeranjang->num_rows > 0) {
  foreach ($queryKeranjang as $keranjang) {
    $subTotal = $keranjang['harga_beli'] * $keranjang['qty'];
    $totalHarga += $subTotal;
  }
}
?>
<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="mb-0"><?= $title ?? '' ?></h5>
  </div>
  <div class="card-body">
    <h6 class="card-title">Data Pembeli</h6>
    <form action="./control/aksi_insert.php" method="post">
      <div class="row mb-3">
        <label class="col-md-2 col-form-label" for="nama_pembeli">Nama Pembeli</label>
        <div class="col-md-10">
          <input type="text" class="form-control" name="nama_pembeli" id="nama_pembeli" required />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-md-2 col-form-label" for="total_harga">Total Harga</label>
        <div class="col-md-10">
          <input type="text" value="<?= $totalHarga ?>" class="form-control" name="total_harga" id="total_harga" readonly />
        </div>
      </div>

      <?php if ($queryKeranjang->num_rows > 0) : ?>
        <div class="form-group">
          <button type="submit" name="pembelian" class="btn btn-success">
            <span class="tf-icons bx bx-save" style="margin-right: .35rem;"></span> Simpan Pembelian
          </button>
        </div>
      <?php endif; ?>
    </form>

    <hr class="my-4">

    <h6 class="card-title">Cart</h6>
    <form action="./control/aksi_insert.php" method="post">

      <div class="row">
        <div class="col-lg-4">
          <div class="mb-3">
            <label class="form-label" for="barang">Pilih Produk</label>
            <select name="id_barang" id="barang" class="form-select" onchange="dataProduk(event)">
              <option value="-1">-- Pilih Produk --</option>
              <?php
              $queryProduk = select($c, 'barang');
              if ($queryProduk->num_rows > 0) :
                foreach ($queryProduk as $barang) :
              ?>
                  <option value="<?= $barang['id_barang'] ?>"><?= $barang['nama_barang'] ?></option>
              <?php endforeach;
              endif; ?>
            </select>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="mb-3">
            <label class="form-label" for="harga_barang">Harga Produk</label>
            <input type="number" min="500" value="0" name="harga_barang" id="harga_barang" class="form-control" readonly>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="mb-3">
            <label class="form-label" for="qty">Jumlah Beli</label>
            <input type="number" min="1" value="1" name="qty" id="qty" class="form-control">
          </div>
        </div>
        <div class="d-none col-lg-12" id="addToCartButton">
          <button type="submit" name="keranjang" class="btn btn-info">
            <span class="tf-icons bx bx-shopping-bag" style="margin-right: .35rem;"></span> Masukkan ke keranjang
          </button>
        </div>
      </div>

    </form>
    <div class="table-responsive mt-3">
      <table id=" table-data" class="table small table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah Beli</th>
            <th>Sub Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
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
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="javascript:void(0);" onclick="deleteData('<?= $keranjang['id_barang'] ?>')">
                        <i class="bx bx-trash me-1"></i> Delete
                      </a>
                    </div>
                  </div>
                </td>
              </tr>
          <?php $i++;
              $totalHarga += $subTotal;
            endforeach;
          else :
            echo "<tr><th class='text-center' colspan='6'>-- Tidak ada data --</th></tr>";
          endif; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

<script>
  function dataProduk(e) {
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