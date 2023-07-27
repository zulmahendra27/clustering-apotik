<div class="card">

  <div class="table-responsive">
    <table id="table-data" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Pembeli</th>
          <th>Total Pembelian</th>
          <th>Waktu</th>
          <th>Detail</th>
          <th>Struk</th>
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
          <td class="text-center"><?= $i ?></td>
          <td><?= $penjualan['nama_pembeli'] ?></td>
          <td><?= $penjualan['total_harga'] ?></td>
          <td><?= date('d-m-Y H:i:s', strtotime($penjualan['waktu'])) ?></td>
          <td class="text-center">
            <button type="button" class="badge badge-success border-none" data-toggle="modal" data-target="#detailModal"
              onclick="detailPenjualan('<?= $penjualan['id_penjualan'] ?>')">
              detail
            </button>
          </td>
          <td class="text-center">
            <a href="./laporan/struk.php?id=<?= $penjualan['id_penjualan'] ?>" target="_blank" class="badge badge-info">
              struk
            </a>
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

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <form action="./control/aksi_update.php" method="post" data-type="add">
        <input type="hidden" name="id_barang" id="id_barang_update">
        <div class="modal-header">
          <h5 class="modal-title" id="detailModalLabel">Detail Penjualan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <div class="row text-dark">
            <div class="col-md-4">Nama Pembeli</div>
            <div class="col-md-8" id="namaPembeli"></div>
          </div>
          <div class="row text-dark mb-3">
            <div class="col-md-4">Total Harga</div>
            <div class="col-md-8" id="totalHarga"></div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped table-bordered dt-responsive" width="100%">
              <thead class="text-center">
                <tr>
                  <th>No</th>
                  <th>Nama Barang</th>
                  <th>Jumlah Beli</th>
                  <th>Harga Barang</th>
                  <th class="text-center">Sub Total</th>
                </tr>
              </thead>
              <tbody id="dataDetail">

              </tbody>
            </table>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function detailPenjualan(id) {
  fetch('./control/aksi_select.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({
        'detail': 'detail',
        'id_penjualan': id
      })
    })
    .then(response => response.json())
    .then(data => {
      let detail = data.detail;
      let bodyTable = document.getElementById('dataDetail');
      let body = "";

      document.getElementById('namaPembeli').innerText = ": " + data.nama_pembeli;
      document.getElementById('totalHarga').innerText = ": " + data.total_harga;

      detail.forEach((e, k) => {
        let subTotal = parseInt(e.qty) * parseInt(e.harga_barang);

        body += "<tr class='text-center'>";
        body += "<td class='text-dark'>" + (k + 1) + "</td>";
        body += "<td class='text-left text-dark'>" + e.nama_barang + "</td>";
        body += "<td class='text-dark'>" + e.qty + "</td>";
        body += "<td class='text-dark'>" + e.harga_barang + "</td>";
        body += "<td class='text-center text-dark'>" + subTotal + "</td>";
        body += "</tr>";
      });

      bodyTable.innerHTML = body;
    })
    .catch(err => console.log(err));
}
</script>