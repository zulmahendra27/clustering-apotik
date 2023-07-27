<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan <?= isset($_GET['p']) ? ucwords(str_replace('_', ' ', $_GET['p'])) : '' ?></title>

  <link href="../assets/vendor/css/core.css" rel="stylesheet">
  <link href="../assets/vendor/css/theme-default.css" rel="stylesheet">
</head>

<body>

  <?php
  include_once "../control/connection.php";
  include_once "../control/helper.php";
  session_start();
  if (isset($_GET['p'])) {
    include_once $_GET['p'] . ".php";
  }
  ?>

  <script>
    window.print();
  </script>
</body>

</html>