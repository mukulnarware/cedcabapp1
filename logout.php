<?php
session_start();
if(isset($_SESSION['user'])){
    echo "<script>alert(Logging out...)</script>";
    // echo 'Logged out';
}
session_destroy();
header('location:login.php');
?>