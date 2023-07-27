<?php
include_once "../control/connection.php";

$id = htmlspecialchars($_GET['id']);
$query = $c->query("SELECT * FROM penjualan WHERE id_penjualan=$id");
$queryDetail = $c->query("SELECT * FROM detail a INNER JOIN barang b ON a.id_barang=b.id_barang WHERE id_penjualan=$id");

if ($query->num_rows <= 0) {
  echo "<script>alert('Data Penjualan tidak Ditemukan');</script>";
  echo "<script>window.location='main.php?p=penjualan';</script>";
  die;
}

$data = mysqli_fetch_assoc($query);

$nama = $data['nama_pembeli'];
$total = $data['total_harga'];
$tanggal_beli = date('d-m-Y H:i', strtotime($data['waktu']));

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Struk</title>

  <style>
  body {
    font-family: 'Courier New', Courier, monospace;
    font-size: 9pt;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .container {
    width: 94%;
    text-align: center;
    padding: 10px;
  }

  .container .title {
    margin: 40px 0;
  }

  .container .detail-buy,
  .container .detail-order {
    width: 80%;
    border: 1px solid black;
    margin: 0 auto;
    margin-bottom: 25px;
  }

  .container table {
    text-align: left;
  }

  .container .honest {
    margin: 50px 0;
  }
  </style>
</head>

<body>

  <div class="container">
    <div class="title">
      <h1 style="margin-bottom: 0;">STRUK PEMBAYARAN</h1>
      <h1 style="margin-top: 0;">APOTIK MADYA</h1>
    </div>

    <div class="detail-buy">
      <table>
        <tr>
          <td style="width: 250px;">Pembeli</td>
          <td>:</td>
          <td><?= $nama ?></td>
        </tr>
        <tr>
          <td>Waktu Pembelian</td>
          <td>:</td>
          <td><?= $tanggal_beli ?></td>
        </tr>
      </table>
    </div>

    <div class="detail-order">
      <table>
        <?php
        foreach ($queryDetail as $detail) :
          $subTotal = intval($detail['harga_barang']) * intval($detail['qty']);
        ?>
        <tr>
          <td style="width: 240px;"><?= $detail['nama_barang'] ?></td>
          <td style="width: 20px;">@</td>
          <td style="width: 110px;"><?= $detail['harga_barang'] . ' x ' . $detail['qty'] ?></td>
          <td style="width: 20px;">=></td>
          <td style="width: 20px;">Rp. </td>
          <td style="text-align: right;"><?= number_format($subTotal, 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <th colspan="6">==========================================================================</th>
        </tr>
        <tr>
          <th colspan="4">Total</th>
          <th>Rp. </th>
          <th style="text-align: right;"><?= str_replace('Rp ', '', $total) ?></th>
        </tr>
      </table>
    </div>

    <div class="honest">
      <p>Terimakasih telah membeli obat di apotik kami.</p>
    </div>

  </div>

  <script>
  window.print();
  </script>
</body>

</html>