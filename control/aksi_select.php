<?php
include_once 'connection.php';
include_once 'helper.php';

if (isset($_POST['detail'])) {
  if ($_POST['detail'] == 'barang') {
    $id_barang = mysqli_escape_string($c, htmlspecialchars($_POST['id_barang']));

    echo json_encode(mysqli_fetch_assoc(select($c, 'barang', ['where' => "id_barang=$id_barang"])));
  } elseif ($_POST['detail'] == 'detail') {
    $id_penjualan = mysqli_escape_string($c, htmlspecialchars($_POST['id_penjualan']));

    $where = "a.id_penjualan=$id_penjualan";
    $join = "INNER JOIN barang b ON a.id_barang=b.id_barang INNER JOIN penjualan c ON a.id_penjualan=c.id_penjualan";
    $query = select($c, 'detail a', ['join' => $join, 'where' => $where]);

    foreach ($query as $detail) {
      $data['nama_pembeli'] = $detail['nama_pembeli'];
      $data['total_harga'] = $detail['total_harga'];
      $data['detail'][] = [
        'nama_barang' => $detail['nama_barang'],
        'qty' => $detail['qty'],
        'harga_barang' => $detail['harga_barang']
      ];
    }

    echo json_encode($data);
  }
} elseif (isset($_POST['laporan'])) {
  session_start();
  if ($_POST['laporan'] == 'penilaian_mapel') {
    $newData = array();
    $id_rombel = mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel']));

    if ($_SESSION['level'] == 'guru') {
      $queryGuru = select($c, 'users a', ['join' => 'INNER JOIN guru b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
      $dataGuru = mysqli_fetch_assoc($queryGuru);
      $where = "b.id_rombel=$id_rombel AND b.id_guru=" . $dataGuru['id_guru'];
    } else {
      $where = "b.id_rombel=$id_rombel";

      // $id_siswa = mysqli_escape_string($c, htmlspecialchars($_POST['id_siswa']));

      $querySiswa = select($c, 'siswa', ['where' => "id_rombel=$id_rombel"]);

      $arraySiswa = array();

      foreach ($querySiswa as $dataSiswa) {
        array_push($arraySiswa, $dataSiswa);
      }

      $newData['data_siswa'] = $arraySiswa;
    }

    $join = "INNER JOIN pengampu b ON a.id_mapel=b.id_mapel";
    $queryMapel = select($c, 'mapel a', ['where' => $where, 'join' => $join]);

    $array = array();

    foreach ($queryMapel as $data) {
      array_push($array, $data);
    }

    $newData['data_mapel'] = $array;

    echo json_encode($newData);
  } elseif ($_POST['laporan'] == 'penilaian_siswa') {
    $id_siswa = mysqli_escape_string($c, htmlspecialchars($_POST['id_siswa']));
    $opt = array(
      'where' => "a.id_siswa=$id_siswa"
    );

    echo json_encode(mysqli_fetch_assoc(select($c, 'penilaian a', $opt)));
  }
} elseif (isset($_POST['absensi'])) {
  session_start();
  if ($_POST['absensi'] == 'absensi') {
    $newData = array();
    $id_rombel = mysqli_escape_string($c, htmlspecialchars($_POST['id_rombel']));

    if ($_SESSION['level'] == 'guru') {
      $queryGuru = select($c, 'users a', ['join' => 'INNER JOIN guru b ON a.id_user=b.id_user', 'where' => "a.username='" . $_SESSION['username'] . "'"]);
      $dataGuru = mysqli_fetch_assoc($queryGuru);
      $where = "b.id_rombel=$id_rombel AND b.id_guru=" . $dataGuru['id_guru'];
    } else {
      $where = "b.id_rombel=$id_rombel";
    }

    $join = "INNER JOIN pengampu b ON a.id_mapel=b.id_mapel";
    $queryMapel = select($c, 'mapel a', ['where' => $where, 'join' => $join]);

    $array = array();

    foreach ($queryMapel as $data) {
      array_push($array, $data);
    }

    $newData['data_mapel'] = $array;

    echo json_encode($newData);
  }
}
