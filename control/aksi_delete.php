<?php
include_once 'connection.php';
include_once 'helper.php';
session_start();

if (isset($_GET['del'])) {
  if ($_GET['del'] == 'barang') {
    $id = mysqli_escape_string($c, htmlspecialchars($_GET['id']));

    $delBarang = delete($c, 'barang', "id_barang=$id");
    $delDataset = delete($c, 'dataset', "id_barang=$id");
    $delKeranjang = delete($c, 'keranjang', "id_barang=$id");
    $delDetail = delete($c, 'detail', "id_barang=$id");

    if ($delBarang && $delDataset && $delKeranjang && $delDetail) {
      $_SESSION['alert'] = alert('Data berhasil dihapus', 'Sukses');
      header("Location: ../main.php?p=produk");
    }
  } elseif ($_GET['del'] == 'keranjang') {
    $id = mysqli_escape_string($c, htmlspecialchars($_GET['id']));

    $username = $_SESSION['username'];
    $queryUser = select($c, 'user', ['where' => "username='$username'"]);
    $id_kasir = mysqli_fetch_assoc($queryUser)['id_user'];

    $queryKeranjang = select($c, 'keranjang', ['where' => "id_barang=$id AND id_kasir=$id_kasir"]);
    $qty = mysqli_fetch_assoc($queryKeranjang)['qty'];

    $queryBarang = select($c, 'barang', ['where' => "id_barang=$id"]);
    $stok_akhir = mysqli_fetch_assoc($queryBarang)['stok'] + $qty;

    $updateStok = update($c, ['stok' => $stok_akhir], 'barang', "id_barang=$id");

    $delBarang = delete($c, 'keranjang', "id_barang=$id");

    if ($updateStok && $delBarang) {
      $_SESSION['alert'] = alertToast('Barnag berhasil dihapus dari keranjang', 'warning');
      header("Location: ../main.php?p=transaksi");
    }
  }
} else {
  var_dump('Test');
}
