<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <link rel="stylesheet" href="../css/home.css">

    <title>header</title>
</head>
<body>
  <div id='navbar'>
  <span id='logo'>CedCab</span>
  <span class='user-login-span'>  <h6 id='user-login-name'> </h6> </span>
  <a class="navbar-brand" href="#">Contact Us</a>
  <!-- <a class="navbar-brand" href="login.php">Login</a> -->
  <a class="navbar-brand" href="../index.php">Dashboard</a>
  <a class="navbar-brand" href="../logout.php">logout</a>
  <a class="navbar-brand" href="index.php">Home</a>
  </div>


<?php

session_start();
if((isset($_SESSION['user']) && $_SESSION['user']['is_admin']==1)){
   echo "Welcome user : ";
    echo($_SESSION['user']['name']);
}else{
    die("<h1 style='color:white;background-color: black'; >you are not otherized to access...</h1>");

}
?>

<?php
include_once '../layout/footer.php';
?>