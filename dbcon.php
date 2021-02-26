<?php

   
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "cabdata";
    
     $con = new mysqli($servername, $username, $password,$dbname);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    // else{
        // $sql="select * from tbl_user";
        // $result=$con->query($sql);
        // if ($result->num_rows > 0) {    
            
        // }else{
        //         echo('no rows found!!');
        //     }
    // }   

?>