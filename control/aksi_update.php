<?php
include_once 'connection.php';
include_once 'helper.php';
session_start();

if (isset($_POST['barang'])) {
  $nama_barang = mysqli_escape_string($c, htmlspecialchars($_POST['nama_barang']));
  $harga = mysqli_escape_string($c, htmlspecialchars($_POST['harga']));

  $id_barang = mysqli_escape_string($c, htmlspecialchars($_POST['id_barang']));
  $dataBarang = array(
    'nama_barang' => $nama_barang,
    'harga' => $harga
  );

  $queryBarang = update($c, $dataBarang, 'barang', "id_barang=$id_barang");

  if ($queryBarang) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'Sukses');
    header("Location: ../main.php?p=produk");
  }
} elseif (isset($_POST['update-stok'])) {
  $id_barang = mysqli_escape_string($c, htmlspecialchars($_POST['id_barang']));

  $queryBarangInBarang = select($c, 'barang', ['where' => "id_barang=$id_barang"]);
  // $queryBarangInDataset = select($c, 'dataset', ['where' => "id_barang=$id_barang"]);

  $barangInBarang = mysqli_fetch_assoc($queryBarangInBarang);
  // $barangInDataset = mysqli_fetch_assoc($queryBarangInDataset);

  $stokBarangInBarang = $barangInBarang['stok'];
  // $stokBarangInDataset = $barangInDataset['all_stok'];

  $stok = mysqli_escape_string($c, htmlspecialchars($_POST['stok']));

  $dataBarang = array(
    'stok' => ($stok + $stokBarangInBarang)
  );

  // $dataDataset = array(
  //   'all_stok' => ($stok + $stokBarangInDataset)
  // );

  $queryBarang = update($c, $dataBarang, 'barang', "id_barang=$id_barang");
  // $queryDataset = update($c, $dataDataset, 'dataset', "id_barang=$id_barang");

  if ($queryBarang) {
    $_SESSION['alert'] = alert('Data berhasil disimpan', 'Sukses');
    header("Location: ../main.php?p=produk");
  }
} elseif (isset($_POST['dataset'])) {
  $id = mysqli_escape_string($c, htmlspecialchars($_POST['id']));
  $value = mysqli_escape_string($c, htmlspecialchars($_POST['value']));

  $split = explode("-", $id);
  $id_barang = $split[0];
  $bulan = $split[1];

  $whereDataset = "id_barang=$id_barang AND bulan=$bulan";
  $checkDataset = select($c, 'dataset', ['where' => $whereDataset]);

  if ($checkDataset->num_rows > 0) {
    $query = update($c, ['penjualan' => $value], 'dataset', $whereDataset);
  } else {
    $dataDataset = [
      'id_barang' => $id_barang,
      'bulan' => $bulan,
      'penjualan' => $value
    ];
    $query = insert($c, $dataDataset, 'dataset');
  }

  if ($query) {
    echo json_encode(['status' => true]);
    return;
  }

  echo json_encode(['status' => false]);
  return;
}
