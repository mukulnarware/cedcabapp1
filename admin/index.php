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
    <link rel="stylesheet" href="../user/dash.css">

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
    echo "<h5 style='color: white; background:black;'>Welcome user : ".$_SESSION['user']['name']."</h5>";

}else{
    die("<h1 style='color:white;background-color: black'; >you are not otherized to access...</h1>");

}
?>

<div class="section-1">
    
    <div class="box">
    <h6>New Ride Requests</h6>
    <h1 id='n-ride'></h1>
    <button type='button' class='btn' id='new-ride-btn'>New Ride Requests</button>
    </div>

    <div class="box"> 
    <h6>Total rides</h6>
    <h1 id='t-ride'></h1>
    <button type='button' class='btn' id='total-ride-btn'>Total rides</button>
        
    </div>
    
    <div class="box">
    <h6>Blocked user</h6>
    <h1 id='b-user'></h1>
    <button type='button' class='btn' id='blocked-user-btn'>Blocked user</button>
    </div>

    <div class='box'>
    <h6>Total Earnings</h6>
    <h1 id='t-earn'></h1>
    <button type='button' class='btn' id='earned-btn'>Total Earnings </button>
    </div>
    

</div>




<table id='main_table'class='table-dark table table-stripes'>

    
</table>
<script>

$(document).ready(function(){
    
    $.ajax({
    url:'../helper.php',
    type: 'POST',
    data:{ action :'get_details_adm'

    },
    success: function(data){
        alert(data);
        data=JSON.parse(data);
        $('#n-ride').text(data['pen_ride']);
        $('#b-user').text(data['blocked-user']);
        $('#t-earn').text(data['total_earned']);
        $('#t-ride').text(data['total_rides']);
    }
});





$.ajax({
    url:'../helper.php',
    type: 'POST',
    data:{ action :'pen_rides_adm'

    },
    success: function(data){
                       $('#main_table').html('');
                          
                          res=JSON.parse(data);
                          // alert('data'+res);
                          // console.log(res);
                          var str="<thead><tr>";
                          for(let head in res[0]){
                              str +="<th>"+head+"</th>";
                          }
                          str+="<th>Action</th></tr></thead>";

                          $('#main_table').append(str);

                          for(let tupple of res){
                              var array=Object.values(tupple);
                          var str1="<tbody><tr>";

                          for(let x in array){
                                  str1 +="<td>"+array[x]+"</td>";
                                 
                                      var rideId=array[0];
                                      var cxId=array[9];
                                      flag=array[8];
                                  
                              }
                              str1 +="<td><button class='green_btn' id='approve-btn-"+rideId+"' onclick='approveRide("+rideId+","+cxId+")'>Approve</button><button class='red_btn' id='cancel-btn-"+rideId+"' onclick='cancelRide_adm("+rideId+","+cxId+")'>Cancel</button></tr></tbody>";
                            $('#main_table').append(str1);


                          }
                             
       
    }
});


$('#total-ride-btn').on('click',()=>{

    $.ajax({
    url:'../helper.php',
    type: 'POST',
    data:{ action :'com_rides_adm'

    },
    success: function(data){
                     $('#main_table').html('');
                          
                         let res=JSON.parse(data);
                          var str="<thead><tr>";
                          
                          for(let head in res[0]){
                              str +="<th>"+head+"</th>";
                          }
                          str+="<th>Action</th></tr></thead>";

                          $('#main_table').append(str);

                          for(let tupple of res){
                              var array=Object.values(tupple);
                              var str1="<tbody><tr>";

                              for(let x in array){
                                    str1 +="<td>"+array[x]+"</td>";
                                   
                                        var rideId=array[0];
                                        var cxId=array[9];
                                        flag=array[8];

                                }
                              str1 +="<td><button class='green_btn' id='view-btn-"+rideId+"' onclick='viewDetails("+rideId+","+cxId+")'>View</button></tr></tbody>";
                            $('#main_table').append(str1);
                        

                        }
                       }


});
});




}); //documnt ready end





</script>

</body>
</html>






























<?php
// include_once '../layout/footer.php';
?>



