<?php
include_once './control/connection.php';
include_once './control/helper.php';

$data = [
  'username' => 'manager',
  'password' => password_hash('manager', PASSWORD_DEFAULT),
  'nama_user' => 'Manager',
  'level' => 'manager'
];

// insert($c, $data, 'user');

$data = [
  'username' => 'kasir',
  'password' => password_hash('kasir', PASSWORD_DEFAULT),
  'nama_user' => 'Kasir',
  'level' => 'kasir'
];

// insert($c, $data, 'user');