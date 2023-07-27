<?php if ($_GET['p'] == 'produk') : ?>
  <div class="card">

    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0"><?= $title ?? '' ?></h5>
      <?php if ($_SESSION['level'] == 'admin') : ?>
        <a href="?p=produk_add" class="btn btn-xs btn-success">Tambah Data</a>
      <?php endif; ?>
    </div>
    <div class="card-body table-responsive text-nowrap">
      <table id="myTable" class="table table-striped pt-4" style="width:100%;">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama Barang</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Harga</th>
            <?php if ($_SESSION['level'] != 'manager') : ?>
              <th class="text-center">Update Stok</th>
            <?php endif;
            if ($_SESSION['level'] == 'admin') : ?>
              <th class="text-center">Aksi</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = select($c, 'barang');
          if ($query->num_rows > 0) :
            $i = 1;
            foreach ($query as $barang) :
          ?>
              <tr class="text-center">
                <td><?= $i ?></td>
                <td class="text-left"><?= $barang['nama_barang'] ?></td>
                <td><?= $barang['stok'] ?></td>
                <td class="text-center"><?= "Rp. " . number_format($barang['harga'], 0, ',', '.') ?></td>
                <?php if ($_SESSION['level'] != 'manager') : ?>
                  <td class="text-center">
                    <button type="button" class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#updateStokModal" onclick="updateStok('<?= $barang['id_barang'] ?>')">
                      Update Stok
                    </button>
                  </td>
                <?php endif;
                if ($_SESSION['level'] == 'admin') : ?>
                  <td>
                    <div class="dropdown">
                      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="?p=produk_add&id=<?= $barang['id_barang'] ?>">
                          <i class="bx bx-edit-alt me-1"></i> Edit
                        </a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="deleteData('<?= $barang['id_barang'] ?>')">
                          <i class="bx bx-trash me-1"></i> Delete
                        </a>
                      </div>
                    </div>
                  </td>
                <?php endif; ?>
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
  $id = '';
  $nama_barang = '';
  $stok = '';
  $harga = '';
  $aksi = 'aksi_insert';

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $queryBarang = select($c, 'barang', ['where' => "id_barang=$id"]);

    if ($queryBarang->num_rows > 0) {
      $data = mysqli_fetch_assoc($queryBarang);
      $id = $data['id_barang'];
      $nama_barang = $data['nama_barang'];
      $stok = $data['stok'];
      $harga = $data['harga'];

      $aksi = 'aksi_update';
    }
  }
  ?>

  <div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0"><?= $title ?? '' ?></h5>
      <a href="?p=produk" class="btn btn-xs btn-info">Kembali</a>
    </div>
    <div class="card-body">
      <form action="./control/<?= $aksi ?>.php" method="post">
        <input type="hidden" name="id_barang" id="id_barang" value="<?= $id ?>">
        <div class="row mb-3">
          <label class="col-md-2 col-form-label" for="nama_barang">Nama Produk</label>
          <div class="col-md-10">
            <input type="text" class="form-control" value="<?= $nama_barang ?>" name="nama_barang" id="nama_barang" />
          </div>
        </div>
        <?php if ($stok == '') : ?>
          <div class="row mb-3">
            <label class="col-md-2 col-form-label" for="stok">Stok</label>
            <div class="col-md-10">
              <input type="number" min="1" value="<?= $stok ?>" class="form-control" name="stok" id="stok" />
            </div>
          </div>
        <?php endif; ?>
        <div class="row mb-3">
          <label class="col-md-2 col-form-label" for="harga">Harga Produk</label>
          <div class="col-md-10">
            <input type="number" min="1" value="<?= $harga ?>" class="form-control" name="harga" id="harga" />
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-md-10">
            <button type="submit" name="barang" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

<?php endif; ?>

<div class="modal fade" id="updateStokModal" tabindex="-1" role="dialog" aria-labelledby="updateStokModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="./control/aksi_update.php" method="post" data-type="add">
        <input type="hidden" name="id_barang" id="id_barang_update">
        <div class="modal-header">
          <h5 class="modal-title" id="updateStokModalLabel">Update Stok</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <h5 class="text-dark mb-3">
            Stok tersedia saat ini: <span id="stokView"></span>
          </h5>

          <div class="form-group row mb-0">
            <label for="stokInputUpdateStok" class="col-sm-4">Tambah Stok</label>
            <div class="col-sm-8">
              <input type="number" min="1" name="stok" class="form-control input-sm" id="stokInputUpdateStok" value="0" placeholder="Stok">
            </div>
          </div>

          <div class="form-group row justify-content-end">
            <div class="col-sm-8 small text-danger">
              Total stok: <span id="totalStok"></span>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="update-stok" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function updateStok(id) {
    let inputStok = document.getElementById('stokInputUpdateStok');
    let totalStokView = document.getElementById('totalStok');
    let stokView = document.getElementById('stokView');

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
        totalStokView.innerHTML = data.stok;
        stokView.innerHTML = data.stok;
        document.getElementById('id_barang_update').value = data.id_barang;

        let totalStok = parseInt(totalStokView.innerText);
        inputStok.addEventListener('keyup', function() {
          totalStokView.innerHTML = (this.value != "" ? (parseInt(this.value) + totalStok) : totalStok);
        });
      })
      .catch(err => console.log(err));
  }

  function deleteData(id) {
    swal({
        title: "Apakah anda ingin menghapus barang?",
        text: "Data yang telah dihapus tidak dapat dikembalikan.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Delete",
        closeOnConfirm: false,
      },
      function() {
        window.location = './control/aksi_delete.php?del=barang&id=' + id;
      }
    );
  }
</script>