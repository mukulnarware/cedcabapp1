<?php



?>
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
    <link rel="stylesheet" href="dash.css">
    <title>header</title>
</head>
<body>
  <div id='navbar'>
  <div id='u-sign'><span id='logo'>CedCab</span></div>
  <a class="navbar-brand" href="#">Contact Us</a>
  <!-- <a class="navbar-brand" href="login.php">Login</a> -->
  <a class="navbar-brand" href="../index.php">Dashboard</a>
  <a class="navbar-brand" href="../logout.php">logout</a>
  <a class="navbar-brand" href="index.php">Home</a>
  <span class='user-login-span'>  <h6 id='user-login-name'> </h6> </span>
</div>

  
  
  <?php
session_start();
if((isset($_SESSION['user']) && $_SESSION['user']['is_admin']==0)){
    echo "<h5 style='color: white; background:black;'>Welcome user : ".$_SESSION['user']['name']."</h5>";
   
}else{
   

    die("<h1 style='color:white ;background-color: black;' >you are not otherized to access...</h1>");
}
?>

<div class="section-1">
    
    <div class="box">
    <h6>Pending rides</h6>
    <h1 id='p-ride'></h1>
    <button type='button' class='btn' id='pending-ride-btn'>Show pending rides</button>
    </div>

    <div class="box"> 
    <h6>Cancelled rides</h6>
    <h1 id='c-ride'></h1>
    <button type='button' class='btn' id='cancelled-ride-btn'>Show cancelled rides</button>
        
    </div>
    
    <div class="box">
    <h6>Total spent</h6>
    <h1 id='t-spent'></h1>
    <button type='button' class='btn' id='total-spent-btn'> Show total spent </button>
    </div>

    <div class='box'>
    <h6>Total rides</h6>
    <h1 id='t-ride'></h1>
    <button type='button' class='btn' id='total-ride-btn'> Show total rides </button>
    </div>
    

</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ride Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-body">
          ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok</button>
          <!-- <button type="button" id='book-ride-btn' class="btn btn-primary" data-bs-dismiss="modal">Book Ride</button> -->
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
    crossorigin="anonymous"></script>

    <!-- <div class="section-1" id='info-table'> -->
    <table id='main_table'class='table-dark table table-stripes'>

    
    </table>


    <!-- </div> -->



    <script>
        function viewDetails(rideId,cxId){
        //  alert('Are you sure want to see details of :'+rideId);
        $.ajax({//ajax-1
                        url:'../helper.php',
                        type:'POST', 
                        data:{   action:'viewDetails',
                              rideId:rideId,
                              cxId:cxId

                              },
                        success: function(res){
                        
                            let data=JSON.parse(res);
                           
                            var bodyData = "<h4>Ride history...</h4> <h6> Ride Date : "+data['ride_date']+"</h6>"+"<h6> From : " + data['from'] + "</h6>" + "<h6> To : " + data['to'] + "</h6>" + "<h6> Luggage : " + data['luggage'] + "</h6>" + "<h6> Cab Type : " + data['cabtype'] + "</h6>" + "<h4> Total Fare : &#8377 " + data['total_fare'] + "/-</h6>";
              
                            $('.modal-body').html(bodyData);
                            $('#exampleModal').modal('show');


                        }//
        });
    }

    function cancelRide(rideId,cxId){
        if(confirm('Are you sure about to cancel this ride with id :'+rideId)){
        $.ajax({//ajax-1
                        url:'../helper.php',
                        type:'POST', 
                        data:{   action:'cancelRide',
                              rideId:rideId,
                              cxId:cxId

                              },
                        success: function(res){
                            alert(res);
                            $('#pending-ride-btn').click();
                            
                        }
        });
        }
    }


                $(document).ready(function(){

                    $.ajax({//ajax-1
                        url:'../helper.php',
                        type:'POST', 
                        data:{   action:'get_details'},
                        success: function(res){
                            res=JSON.parse(res);
                            
                           if(res['tot_spent']==null){
                                res['tot_spent']=0;
                            }
                            $('#p-ride').text(res['pen_ride']);
                            $('#c-ride').text(res['can_ride']);
                            $('#t-spent').text(res['tot_spent']);
                            $('#t-ride').text(res['tot_ride']);

                            // $('#table').append('<thead><td>my data</td><td>more data</td></tr>');
                     $.ajax({//ajax-1
                        url:'../helper.php',
                        type:'POST', 
                        data:{   action:'pen_rides'},
                        success: function(res){
                            $('#main_table').html('');
                          
                            
                            res=JSON.parse(res);
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
                                    
                                }
                                str1 +="<td><button id='cancel-btn-"+rideId+"' onclick='cancelRide("+rideId+","+cxId+")'>Cancel</button></td></tr></tbody>";
                              $('#main_table').append(str1);

                            }
                      
                        }


                    });

                        }
                    })
                //  jaxx-1 for pending ride details

                $('#pending-ride-btn').on('click',()=>{

                        
                    $.ajax({//ajax-1
                        url:'../helper.php',
                        type:'POST', 
                        data:{   action:'pen_rides'},
                        success: function(res){
                            $('#main_table').html('');
                          
                            res=JSON.parse(res);
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
                                    
                                }
                                str1 +="<td><button id='cancel-btn-"+rideId+"' onclick='cancelRide("+rideId+","+cxId+")'>Cancel</button></tr></tbody>";
                              $('#main_table').append(str1);

                            }
                                               

                        }


                    });

                });
                //  jaxx-2 for cancelled ride details

                $('#cancelled-ride-btn').on('click',()=>{

                    $('#main_table').html('');
                        
                    $.ajax({//ajax-2
                        url:'../helper.php',
                        type:'POST', 
                        data:{   action:'can_rides'},
                        success: function(res){
                            $('#main_table').html('');
                          
                          res=JSON.parse(res);
                        
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
                                    
                                }
                              str1 +="<td><button id='view-btn-"+rideId+"' onclick='viewDetails("+rideId+","+cxId+")'>View</button></tr></tbody>";
                            $('#main_table').append(str1);

                          }
                    
                      }




                    });//ajax-2

                });

            //  jaxx-3 for completed ride details

            $('#total-spent-btn').on('click',()=>{

                                            
                    $.ajax({//ajax-3
                        url:'../helper.php',
                        type:'POST', 
                        data:{   action:'com_rides'},
                        success: function(res){
                            $('#main_table').html('');
                          
                          res=JSON.parse(res);
                         
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
                                    
                                }
                              str1 +="<td><button id='view-btn-"+rideId+"' onclick='viewDetails("+rideId+","+cxId+")'>View</button></tr></tbody>";
                            $('#main_table').append(str1);
                        

                        }
                       }


                    });//ajax-3

            });

             //  jaxx-4 for total rides  details

            $('#total-ride-btn').on('click',()=>{

                                                            
                $.ajax({//ajax-3
                    url:'../helper.php',
                    type:'POST', 
                    data:{   action:'total_rides'},
                    success: function(res){
                        $('#main_table').html('');
                          
                          res=JSON.parse(res);
                       
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
                                        var status=array[8];
                                }
                                if(status!='1'){
                                    str1 +="<td><button id='view-btn-"+rideId+"' onclick='viewDetails("+rideId+","+cxId+")'>View</button></td></tr></tbody>";
                                }else{
                                str1 +="<td><button id='cancel-btn-"+rideId+"' onclick='cancelRide("+rideId+","+cxId+")'>Cancel</button></td></tr></tbody>";
                                }
                            $('#main_table').append(str1);
                        
                        }
                    
                    }


                });//ajax-4

            });



                }); //documenet.ready
    
    </script>
</body>
</html>
<?php
// include_once '../layout/footer.php';
?>