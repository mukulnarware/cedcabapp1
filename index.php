<?php
include 'layout/arrays.php';
include 'layout/header.php';

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="css/home.css">

  <title>homePage</title>
</head>

<body>

  <!-- ////navbar -->
<!-- 
  <div id='navbar'>
    <a class="navbar-brand" href="#">Home</a>
    <a class="navbar-brand" href="login.php">Login</a>
    <a class="navbar-brand" href="signup.php">Sign Up</a>
    <a class="navbar-brand" href="#">Contact Us</a>
  </div> -->


  <div class="container">
    
    
    
    <form id='myform'>
      <h5 id='logo-tag'>CedCab</h5>
      <h3>Calculate fare</h3>
    <div>
      <label for="pickup" class='label'>PickUp</label>
      <select name="pickup" id="pickup">

        <option value="-1">select Pickup</option>
        <?php

foreach($locations as $key => $value){
  
  echo "<option value='$key'>$key</option>";
}

?>
        </select>
        
      </div>
      <div>
        
        <label for="drop" class='label'> Drop</label>
        <select name="drop" id="drop">
          
          <option value=-1>Select Drop</option>
          <?php
              foreach($locations as $key => $value){
                echo "<option value='$key'>$key</option>";
              }
              ?>
        </select>
        
      </div>
      
      <div>
        
        <label for="cabtype" class='label'> Cab Type</label>
        <select name="cabtype" id="cabtype">
          <option value=-1>Select CabType</option>
          <?php
              foreach($cabs as $key){
                
                echo "<option value='$key'>$key</option>";
              }
              ?>

</select>

</div>

      <div>
        
        <label for="luggage" class='label'>Luggage</label>
        <input type="number" name="luggage" id="luggage" placeholder='Enter Weight(kg)'>
        <input type='hidden' name='action' value='fareCalculate'> 
<!-- // using it for the action page recognition -->
        
      </div>
      <div>
        <button type='button' id='cal_fare' class='btn'>Get Fare</button>
        <button type='reset' id='reset' class='btn'>Reset</button>
      </div>
      
    </form>

  </div>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ride Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-body">
          
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" id='book-ride-btn' class="btn btn-primary" data-bs-dismiss="modal">Book Ride</button>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
    crossorigin="anonymous"></script>
  <script>
    $(document).ready(() => {
var ride_data;
     
$('#book-ride-btn').on('click',()=>{
                $.ajax({
                  url:'helper.php',
                  type:'POST',
                  data:{
                    action:'get_booking',
                    ride_data:ride_data
                  },
                  success: function(data){
                      // alert(data);

                    if(data==1){

                    alert("Your ride successfully booked..."+data);
                    window.location.href='/AJAX/CED_CAB_APP/user/';
                    }else if(data==0){
                      alert('something went wrong!');
                    }else if(data==-1){
                      alert('Please login to book your cab');
                      window.location.href='/AJAX/CED_CAB_APP/login.php';
                    }else{
                      // alert(data);
                    }

                  }

                });
              });
      $('#cal_fare').on('click', (e) => {
        if ($('#cabtype').val() == 'CedMicro') {
          $("#luggage").prop('disabled', false);
        }

        $.ajax({
          url: 'helper.php',
          type: 'POST',
          data: $('#myform').serialize(),
          success: function (data1) {

            if ($('#cabtype').val() == 'CedMicro') {
              $("#luggage").prop('disabled', true);
            }
            if (data1 == -1) {
              alert("Please select the Drop / PickUp loacotions");

            } else {
              let data = JSON.parse(data1);
                ride_data=data;

              if (data['cabtype'] != 'CedMicro') {
                var bodyData = "<h4>Cab Fare Calculation.</h4> <h6> From : " + data['pickup'] + "</h6>" + "<h6> To : " + data['drop'] + "</h6>" + "<h6> Luggage : " + data['luggage'] + "</h6>" + "<h6> Cab Type : " + data['cabtype'] + "</h6>" + "<h4> Total Fare : &#8377 " + data['fare'] + "/-</h6>";
              } else {
                var bodyData = "<h4>Cab Fare Calculation.</h4> <h6> From : " + data['pickup'] + "</h6>" + "<h6> To : " + data['drop'] + "</h6>" + "<h6> Luggage : Not applied</h6>" + "<h6> Cab Type : " + data['cabtype'] + "</h6>" + "<h4> Total Fare : &#8377 " + data['fare'] + "/-</h6>";
              }


              $('.modal-body').html(bodyData);
              $('#exampleModal').modal('show');


            }

          },
          error: function (error) {
            alert('error: ' + error);
          }

        });

      });



      ////////////////////
      // This code hide that location name from drop that user has selected at pickup
      $('#pickup').change(() => {
        // alert($('#pickup').val());

        $("#drop > option[value='" + $('#pickup').val() + "'").hide();

      })

      // (vice versa)This code hide that location name from pick that user has selected at drop
      $('#drop').change(() => {
        // alert($('#pickup').val());

        $("#pickup > option[value='" + $('#drop').val() + "'").hide();

      })
      ///////


      // code handles the luggage problem with CEDMINI cab and disables the luggage section 
      $('#cabtype').change(() => {

        if ($('#cabtype').val() == 'CedMicro') {

          $("#luggage").prop('placeholder', "Can't Carry Luggage");
          $("#luggage").val('');
          $("#luggage").prop('disabled', true);
        } else {
          $("#luggage").prop('disabled', false);
          $("#luggage").val('');
          $("#luggage").prop('placeholder', "Enter Weight(kg)");


        }

      })
    });
/////////////////////////////

  </script>


</body>

</html>
<?php
include_once 'layout/footer.php';
?>