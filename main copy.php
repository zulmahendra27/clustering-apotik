<!DOCTYPE html>
<html lang="en">

<?php include_once "./control/cek_login.php"; ?>
<?php include_once "./control/helper.php"; ?>

<?php
$title = 'Dashboard';
if (isset($_GET['p'])) {
  $title = ucwords(str_replace('_', ' ', $_GET['p']));
}
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= $title ?></title>

  <!-- ================= Favicon ================== -->
  <!-- Standard -->
  <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
  <!-- Retina iPad Touch Icon-->
  <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
  <!-- Retina iPhone Touch Icon-->
  <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
  <!-- Standard iPad Touch Icon-->
  <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
  <!-- Standard iPhone Touch Icon-->
  <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">

  <!-- Styles -->
  <link href="./assets/css/lib/font-awesome.min.css" rel="stylesheet">
  <link href="./assets/css/lib/themify-icons.css" rel="stylesheet">
  <link href="./assets/css/lib/data-table/buttons.bootstrap.min.css" rel="stylesheet" />
  <link href="./assets/css/lib/menubar/sidebar.css" rel="stylesheet">
  <link href="./assets/css/lib/bootstrap.min.css" rel="stylesheet">
  <link href="./assets/css/lib/sweetalert/sweetalert.css" rel="stylesheet">
  <link href="./assets/css/lib/toastr/toastr.min.css" rel="stylesheet">
  <link href="./assets/css/lib/helper.css" rel="stylesheet">
  <link href="./assets/css/style.css" rel="stylesheet">

  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">

  <style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  </style>
</head>

<body>

  <?php include_once "./templates/sidebar.php" ?>

  <?php include_once "./templates/header.php" ?>

  <div class="content-wrap">
    <div class="main">
      <div class="container-fluid">

        <?php include_once "./templates/breadcrumb.php" ?>

        <!-- /# row -->
        <section id="main-content">
          <div class="row">
            <div class="col-lg-12">

              <?php if (!isset($_GET['p'])) {
                include_once('dashboard.php');
              } else {
                include_once($_GET['p'] . '.php');
              } ?>

            </div>
            <!-- /# column -->
          </div>
          <!-- /# row -->

          <div class="row">
            <div class="col-lg-12">
              <div class="footer">
                <p><?= date('Y') ?> © K-Means Clustering</p>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <!-- jquery vendor -->
  <script src="./assets/js/lib/jquery.min.js"></script>
  <script src="./assets/js/lib/jquery.nanoscroller.min.js"></script>
  <!-- nano scroller -->
  <script src="./assets/js/lib/menubar/sidebar.js"></script>
  <script src="./assets/js/lib/preloader/pace.min.js"></script>
  <!-- sidebar -->

  <!-- bootstrap -->
  <script src="./assets/js/lib/sweetalert/sweetalert.min.js"></script>
  <script src="./assets/js/lib/toastr/toastr.min.js"></script>
  <script src="./assets/js/lib/bootstrap.min.js"></script>
  <script src="./assets/js/scripts.js"></script>

  <!-- scripit init-->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#table-data').DataTable();
      $('.perhitungan').DataTable();
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

  <!-- <script src="./assets/js/lib/data-table/datatables.min.js"></script>
  <script src="./assets/js/lib/data-table/dataTables.buttons.min.js"></script>
  <script src="./assets/js/lib/data-table/buttons.flash.min.js"></script>
  <script src="./assets/js/lib/data-table/jszip.min.js"></script>
  <script src="./assets/js/lib/data-table/pdfmake.min.js"></script>
  <script src="./assets/js/lib/data-table/vfs_fonts.js"></script>
  <script src="./assets/js/lib/data-table/buttons.html5.min.js"></script>
  <script src="./assets/js/lib/data-table/buttons.print.min.js"></script>
  <script src="./assets/js/lib/data-table/datatables-init.js"></script> -->

  <?php if (isset($_SESSION['alert'])) {
    echo $_SESSION['alert'];
    unset($_SESSION['alert']);
  } ?>

</body>

</html>