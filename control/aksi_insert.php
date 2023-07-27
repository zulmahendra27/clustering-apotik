<?php
include_once 'connection.php';
include_once 'helper.php';
session_start();
date_default_timezone_set("Asia/Jakarta");

$username = $_SESSION['username'];
$queryUser = select($c, 'user', ['where' => "username='$username'"]);
$id_kasir = mysqli_fetch_assoc($queryUser)['id_user'];

if (isset($_POST['barang'])) {
  $nama_barang = mysqli_escape_string($c, htmlspecialchars($_POST['nama_barang']));
  $stok = mysqli_escape_string($c, htmlspecialchars($_POST['stok']));
  $harga = mysqli_escape_string($c, htmlspecialchars($_POST['harga']));

  $dataBarang = array(
    'nama_barang' => $nama_barang,
    'stok' => $stok,
    'harga' => $harga
  );

  $queryBarang = insert($c, $dataBarang, 'barang');

  // $dataDataset = array(
  //   'id_barang' => mysqli_insert_id($c),
  //   'penjualan' => 0,
  //   'all_stok' => $stok
  // );

  // $queryDataset = insert($c, $dataDataset, 'dataset');

  if ($queryBarang) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'Sukses');
    header("Location: ../main.php?p=produk");
  }
} elseif (isset($_POST['keranjang'])) {

  $id_barang = mysqli_escape_string($c, htmlspecialchars($_POST['id_barang']));
  $qty = mysqli_escape_string($c, htmlspecialchars($_POST['qty']));
  $harga_beli = mysqli_escape_string($c, htmlspecialchars($_POST['harga_barang']));

  $queryBarang = select($c, 'barang', ['where' => "id_barang=$id_barang"]);
  $stok = mysqli_fetch_assoc($queryBarang)['stok'];

  if ($qty > $stok) {
    $_SESSION['alert'] = alert('Gagal', 'Pembelian melebihi stok', 'error');
  } else {
    $cekKeranjang = select($c, 'keranjang', ['where' => "id_kasir=$id_kasir AND id_barang=$id_barang"]);

    if ($cekKeranjang->num_rows <= 0) {
      $dataKeranjang = array(
        'id_kasir' => $id_kasir,
        'id_barang' => $id_barang,
        'qty' => $qty,
        'harga_beli' => $harga_beli
      );

      $queryKeranjang = insert($c, $dataKeranjang, 'keranjang');

      $sisaStok = $stok - $qty;
      $querySisaStok = update($c, ['stok' => $sisaStok], 'barang', "id_barang=$id_barang");

      // $dataDataset = array(
      //   'id_keranjang' => mysqli_insert_id($c),
      //   'penjualan' => 0,
      //   'all_stok' => $stok
      // );

      // $queryDataset = insert($c, $dataDataset, 'dataset');

      if ($queryKeranjang && $querySisaStok) {
        $_SESSION['alert'] = alert('Berhasil ditambahkan ke keranjang', 'success');
      }
    } else {
      $_SESSION['alert'] = alert('Barang sudah ada di keranjang', '', 'error');
    }

    header("Location: ../main.php?p=transaksi");
  }
} elseif (isset($_POST['pembelian'])) {
  $nama_pembeli = mysqli_escape_string($c, htmlspecialchars($_POST['nama_pembeli']));
  $total_harga = mysqli_escape_string($c, htmlspecialchars($_POST['total_harga']));

  $dataPenjualan = [
    'nama_pembeli' => $nama_pembeli,
    'total_harga' => $total_harga
  ];

  $insertPenjualan = insert($c, $dataPenjualan, 'penjualan');
  $id_penjualan = mysqli_insert_id($c);

  $monthNow = intval(date('m'));

  $queryKeranjang = select($c, 'keranjang', ['where' => "id_kasir=$id_kasir"]);
  $dataDetail['key'] = ['id_penjualan', 'id_barang', 'qty', 'harga_barang'];
  $dataDetail['values'] = [];

  foreach ($queryKeranjang as $key => $keranjang) {
    $id_barang = $keranjang['id_barang'];
    $qty = $keranjang['qty'];
    $harga_barang = $keranjang['harga_beli'];

    $whereDataset = "id_barang=$id_barang AND bulan=$monthNow";
    $queryDataset = select($c, 'dataset', ['where' => $whereDataset]);

    if ($queryDataset->num_rows > 0) {
      $dataDataset = mysqli_fetch_assoc($queryDataset);
      $penjualan = $dataDataset['penjualan'] + $qty;

      update($c, ['penjualan' => $penjualan], 'dataset', "id_barang=$id_barang AND bulan=$monthNow");
    } else {
      $arrayDataset = [
        'id_barang' => $id_barang,
        'bulan' => $monthNow,
        'penjualan' => $qty
      ];
      insert($c, $arrayDataset, 'dataset');
    }

    $dataDetail['values'][$key] = [$id_penjualan, $id_barang, $qty, $harga_barang];

    // $queryDataset = select($c, 'dataset', ['where' => "id_barang=$id_barang"]);
    // $totalPenjualan = mysqli_fetch_assoc($queryDataset)['penjualan'] + $qty;

    // $updateDataset = update($c, ['penjualan' => $totalPenjualan], 'dataset', "id_barang=$id_barang");
  }

  $insertDetail = insert_batch($c, $dataDetail, 'detail');

  $deleteKeranjang = delete($c, 'keranjang', "id_kasir=$id_kasir");

  if ($insertPenjualan && $insertDetail && $deleteKeranjang) {
    $_SESSION['alert'] = alert('Terimakasih telah berbelanja', 'Sukses');
    header("Location: ../main.php?p=transaksi");
  }
} elseif (isset($_POST['dataset'])) {
  $bulan = mysqli_escape_string($c, htmlspecialchars($_POST['bulan']));
  $penjualan = $_POST['penjualan'];

  $delPerBulan = delete($c, 'dataset', "bulan=$bulan");
  $queryBarang = select($c, 'barang');

  $data['key'] = ['id_barang', 'bulan', 'penjualan'];
  $data['values'] = [];

  if ($queryBarang->num_rows > 0) {
    foreach ($queryBarang as $key => $barang) {
      $data['values'][] = [$barang['id_barang'], $bulan, $penjualan[$key]];
    }
  }

  $insertDataset = insert_batch($c, $data, 'dataset');

  if ($delPerBulan && $insertDataset) {
    $_SESSION['alert'] = alert('Dataset berhasil disimpan', 'Sukses');
    header("Location: ../main.php?p=dataset");
  }
}
