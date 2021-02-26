<?php

include_once '../header.php';

session_start();
if((isset($_SESSION['user']) && $_SESSION['user']['is_admin']==0)){
    echo "Welcome user : ";
    echo($_SESSION['user']['name']);

}else{
    die("you are not otherized to access...");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
    
</body>
</html>