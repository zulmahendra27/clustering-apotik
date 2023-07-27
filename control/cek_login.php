<?php
include_once "connection.php";
session_start();

$url = parse_url($_SERVER['REQUEST_URI']);
$path = explode('/', $url['path']);

if (!isset($_SESSION['login'])) {
  if (isset($_POST['username']) && !empty($_POST['username'])) {
    $username = mysqli_escape_string($c, htmlspecialchars($_POST['username']));

    $data = mysqli_fetch_array($c->query("SELECT * FROM user WHERE username='$username'"));

    if ($data != NULL) {
      $hash = $data['password'];
      $password = mysqli_escape_string($c, $_POST['password']);
      if (password_verify($password, $hash)) {
        $level = $data['level'];
        $id_user = $data['id_user'];
        $data_user = mysqli_fetch_assoc($c->query("SELECT * FROM user WHERE id_user='$id_user'"));
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $data_user['nama_user'];
        $_SESSION['level'] = $data['level'];
        header("Location: ../main.php");
      } else {
        $_SESSION['alert'] = "<script>swal('Login Gagal!', 'Mohon periksa kembali username atau password', 'error')</script>";
        header("Location: ../login.php");
      }
    } else {
      $_SESSION['alert'] = "<script>swal('Login Gagal!', 'Mohon periksa kembali username atau password', 'error')</script>";
      header("Location: ../login.php");
    }
  } else {
    if ($path[2] == 'login.php') {
      return;
    }

    $_SESSION['alert'] = "<script>swal('Login Gagal!', 'Mohon periksa kembali username atau password', 'error')</script>";
    header("Location: login.php");
  }
} else {
  if ($path[2] == 'main.php') {
    return;
  }
  header("Location: main.php?p=dashboard");
}
