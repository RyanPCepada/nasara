
<!-- 
    <php
session_start();

if(!isset($_SESSION['user_ID'])){
    echo ("<script>window.location.href = 'login_main.php';</script>");
    exit();
}

?> -->




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/boxicons.min.css">
  
    <title>Nasara</title>
</head>
<body>
    <!-- <h1>DASH BOARD</h1> -->
    <script src="assets/js/jquery-3.7.1.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/global.js"></script>

    <script>
    function to_landing() {
      window.location.href = 'landing_main.php';
    }
    </script>

    <!-- <script>
    function to_login() {
      window.location.href = 'login_main.php';
    }
    </script> -->

</body>
</html>