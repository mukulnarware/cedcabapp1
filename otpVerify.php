<?php
session_start();
$_SESSION['user-login']=false;
//opt comparision
    $u_otp =$_POST['otp'];
    $g_otp=$_SESSION['otp'];
    
    if($u_otp==$g_otp)
    {
        $_SESSION['user-login']=true;
        echo (1);
            
    }
    else
    {
        echo (0);
    }


?>