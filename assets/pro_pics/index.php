<?php
session_start();
if((isset($_SESSION['user']) && $_SESSION['user']['is_admin']==0)){
    echo "<h5 style='color: white; background:black;'>Welcome user : ".$_SESSION['user']['name']."</h5>";
   
}else{
   

    die("<h1 style='color:white ;background-color: black;' >you are not otherized to access...</h1>");
}
    ?>