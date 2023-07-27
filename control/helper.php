<?php
// Fungsi DML
function select($c, $table, $opt = [])
{
  $select = array_key_exists('select', $opt) ? $opt['select'] : '*';
  $where = array_key_exists('where', $opt) ? ("WHERE " . $opt['where']) : '';
  $group = array_key_exists('group', $opt) ? ('GROUP BY ' . $opt['group']) : '';
  $order = array_key_exists('order', $opt) ? ('ORDER BY ' . $opt['order']) : '';
  $limit = array_key_exists('limit', $opt) ? ('LIMIT ' . $opt['limit']) : '';

  if (array_key_exists('join', $opt)) {
    return $c->query("SELECT $select FROM $table $opt[join] $where $order $group $limit");
  }

  return $c->query("SELECT $select FROM $table $where $order $group $limit");
}

function insert($c, $data, $table)
{
  $key = array();
  $value = array();

  foreach ($data as $k => $v) {
    array_push($key, $k);
    array_push($value, "'" . $v . "'");
  }

  $column = implode(',', $key);
  $values = implode(',', $value);

  return $c->query("INSERT INTO $table($column) VALUES ($values)");
}

function insert_batch($c, $data, $table)
{
  $column = implode(',', $data['key']);
  // $values = implode(',', $data['values']);
  $values = [];
  foreach ($data['values'] as $newData) {
    $values[] = "('" . implode("','", $newData) . "')";
  }

  $newValues = implode(',', $values);

  return $c->query("INSERT INTO $table($column) VALUES $newValues");
  // return $newValues;
}

function update($c, $data, $table, $where)
{
  // $key = array();
  $value = array();

  foreach ($data as $k => $v) {
    // array_push($key, $k);
    array_push($value, $k . "='" . $v . "'");
  }

  $values = implode(',', $value);

  return $c->query("UPDATE $table SET $values WHERE $where");
}

function delete($c, $table, $where)
{
  return $c->query("DELETE FROM $table WHERE $where");
}

// =========================================================================================


// Fungsi Alert
function alert($title, $desc, $type = 'success')
{
  return html_entity_decode("<script>swal('$title', '$desc', '$type');</script>");
}

function alertToast($text, $type = 'success')
{
  $alert = "
    toastr." . $type . "('" . $text . "','" . ucwords($type) . "',{
      timeOut: 5000,
      'closeButton': true,
      'debug': false,
      'newestOnTop': true,
      'progressBar': true,
      'positionClass': 'toast-top-right',
      'preventDuplicates': true,
      'onclick': null,
      'showDuration': '300',
      'hideDuration': '1000',
      'extendedTimeOut': '1000',
      'showEasing': 'swing',
      'hideEasing': 'linear',
      'showMethod': 'fadeIn',
      'hideMethod': 'fadeOut',
      'tapToDismiss': false
    })
  ";

  return html_entity_decode("<script>$alert</script>");
}


// =========================================================================================

// Fungsi Sort
function sortMultiDimensionalArray(&$array, $index)
{
  usort($array, function ($a, $b) use ($index) {
    return $a[$index] - $b[$index];
  });
}

function sortMultiArray($array)
{
  array_multisort(array_map(function ($element) {
    return $element[1];
  }, $array), SORT_ASC, $array);

  return $array;
}

// ======================================================================
// Fuzzy C-Means Function
function keanggotaanCluster($cDataset, $cKriteria)
{
  $arrayRandom = array();
  // Looping dari jumlah dataset
  for ($h = 0; $h < $cDataset; $h++) {
    // Membuat array kosong untuk menyimpan bilangan acak
    $numbers = array();

    // Menghasilkan 4 bilangan acak antara 0 dan 1
    for ($i = 0; $i < $cKriteria; $i++) {
      $number = mt_rand(0, 100) / 100; // Menghasilkan bilangan acak antara 0 dan 1 dengan 2 desimal
      $numbers[] = $number; // Menambahkan bilangan ke dalam array
    }

    // Menghitung jumlah sementara dari 4 bilangan acak
    $total = array_sum($numbers);

    // Menghitung faktor skala untuk menjaga jumlah tetap 1
    $scaleFactor = 1 / $total;

    // Mengalikan semua bilangan dengan faktor skala
    $numbers = array_map(function ($number) use ($scaleFactor) {
      $newNumber = $number * $scaleFactor;
      return round($newNumber, 3);
    }, $numbers);

    // Mencetak kelima bilangan acak
    $arrayRandom[] = $numbers;
  }

  return $arrayRandom;
}

function cariTerbesar($arr)
{
  $terbesar = $arr[0];  // Menginisialisasi variabel terbesar dengan elemen pertama dari array
  $indeksTerbesar = 0;  // Menginisialisasi variabel indeksTerbesar dengan 0

  foreach ($arr as $indeks => $elemen) {
    if ($elemen > $terbesar) {
      $terbesar = $elemen;
      $indeksTerbesar = $indeks;
    }
  }

  return $indeksTerbesar;
}

function bulanIndo($bulan)
{
  $array = [
    1 => 'januari',
    'februari',
    'maret',
    'april',
    'mei',
    'juni',
    'juli',
    'agustus',
    'september',
    'oktober',
    'november',
    'desember'
  ];

  return $array[$bulan];
}

function getMonthRange($startMonth, $endMonth)
{
  // Jika endmonth lebih kecil dari startmonth, tambahkan 12 agar memperhitungkan perbedaan tahun
  if ($endMonth < $startMonth) {
    $endMonth += 12;
  }

  // Hitung selisih bulan
  $monthDifference = $endMonth - $startMonth + 1;

  return $monthDifference;
}
