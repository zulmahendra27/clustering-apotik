<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="./assets/" data-template="vertical-menu-template-free">

<?php include_once "./control/cek_login.php"; ?>
<?php include_once "./control/helper.php"; ?>

<?php
$WEB_NAME = "APOTIK MADYA";
$title = 'Dashboard';
if (isset($_GET['p'])) {
  $split = explode('_', $_GET['p']);
  $title = ucwords(str_replace('_', ' ', $split[0]));
}
?>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title><?= $title ?? '' ?></title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="./assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="./assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="./assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="./assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="./assets/css/demo.css" />

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link href="./assets/libs/sweetalert/sweetalert.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/vendor/libs/toastr/toastr.min.css">

  <!-- Helpers -->
  <script src="./assets/vendor/js/helpers.js"></script>

  <script src="./assets/js/config.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      <?php include_once "./templates/sidebar.php" ?>

      <!-- Layout container -->
      <div class="layout-page">

        <?php include_once "./templates/header.php" ?>

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">

            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> <?= $title ?? '' ?></h4>

            <?php if (!isset($_GET['p'])) {
              include_once('dashboard.php');
            } else {
              // $split = explode('_', $_GET['p']);
              include_once($split[0] . '.php');
            } ?>

          </div>
          <!-- / Content -->

          <?php include_once "./templates/footer.php" ?>

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="./assets/vendor/libs/jquery/jquery.js"></script>
  <script src="./assets/vendor/libs/popper/popper.js"></script>
  <script src="./assets/vendor/js/bootstrap.js"></script>
  <script src="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="./assets/vendor/js/menu.js"></script>
  <script src="./assets/libs/sweetalert/sweetalert.min.js"></script>
  <script src="./assets/vendor/libs/toastr/toastr.min.js"></script>

  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

  <!-- Main JS -->
  <script src="./assets/js/main.js"></script>

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <script>
    window.addEventListener("DOMContentLoaded", (event) => {
      let table = new DataTable('#myTable');
    });

    function logout() {
      swal({
          title: "Apakah anda ingin keluar?",
          text: "Anda dapat login kembali kapan saja.",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Keluar",
          closeOnConfirm: false,
        },
        function() {
          window.location = './logout.php';
        }
      );
    }
  </script>

  <?php if (isset($_SESSION['alert'])) {
    echo $_SESSION['alert'];
    unset($_SESSION['alert']);
  } ?>
</body>

</html>