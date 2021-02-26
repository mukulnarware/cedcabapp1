<?php
include_once 'layout/header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
  <link rel="stylesheet" href="css/home.css">
  <!-- <link rel="stylesheet" href="css/login.css"> -->


    <title>login page</title>
  

</head>
<body>

<div class="container">
    <form id='signup-form' method='POST' enctype="multipart/form-data">
    <h2>Sign up page</h2>
    <div class='otp-notify'></div>
  <div>
    <label for="name" class='label'>Name</label>
    <input type="text" id="name" name='name' placeholder='Enter Your Name' required>

  </div>


  <div>
    <label for="email" class='label'>Email</label>
    <input type="email" id="email" name='email' placeholder='Enter Email or username' required>
    
  </div>
<div>
    <button type='button' id='email-otp-btn' class='btn'>Verify</button>
    <input type="number" name="email-otp" id="email-otp" placeholder='Enter OTP' required>
</div>
<input type='hidden' name='action' value='signup'> 
<!-- // using it for the action page recognition -->
  <div>
    <label for="mobile" class='label'>Mobile no.</label>
    <input type='number' id="mobile" name='mobile' placeholder='Enter Mobile no.' required>

  </div>

  <div>
    <label for="pro_pic" class='label'>Profile pic</label>
    <input type='file' id="pro_pic" name='pro_pic' placeholder='Choose profile picture' >

  </div>
  <div>

    <label for="password" class='label' > Password</label>
    <input type="password" id="password" name='password' placeholder='Enter Password' required>

  </div>

  <!-- <div id='otp-div'>
  <input type="number" id="u-otp">
  </div> -->


  <div>
    <button type='submit' id='signup-btn' class='btn'>Sign Up</button>
    <button type='reset' id='reset' class='btn'>Reset</button>
  </div>

</form>
</div>

<script>
$(document).ready(()=>{


// for otp send
$('#email').on('blur',()=>{
    if($('#email').val()!="" && $('#email').val()!=null && $('#email').val()!=" "){
// $('#email-otp').show();
// $('#email-otp-btn').show();
// sending otp on email
$.ajax({
    url:'sendEmail.php',
    type: 'POST',
    data: { 
          email: $('#email').val(),
          name: $('#name').val()               
    },
    success: function(data){
      // alert("->"+data);
    if(data==1){
    $('.otp-notify').html("<p style='color : green;font-size:12px; '>OTP has been sent on : "+$('#email').val()+"</p>");
    $('#email-otp').show();
    $('#email-otp-btn').show();
     }else if(data==0){
        $('.otp-notify').html("<p style='color : red; font-size:12px;'> Please Enter Valid Email ID</p>");

     }else if(data==-1){
          $('.otp-notify').html("<p style='color : red; font-size:12px;'>This Email ID is already exists!");
        }

    }
});
//for otp verification
$('#email-otp-btn').on('click',()=>{
    
    $.ajax({
    url:'otpVerify.php',
    type: 'POST',
    data: { 
       otp :$('#email-otp').val()                     
    },
    success: function(data){
        if(data==1){
            $('.otp-notify').html("<p style='color : green; font-size:12px; '>OTP verified successfully");
            $('#signup-btn').show();

        }else if(data==0){$('.otp-notify').html("<p style='color : red; font-size:12px; '>Oops.. OTP incorrect!!");
        }
        
        

    }
});


});

// ,$('#signup-form').serialize(),
// for form submission
$('#signup-form').on('submit',(e)=>{
e.preventDefault();

var formData= new FormData(document.getElementById('signup-form'));

$.ajax({
    url: 'helper.php',
    type: 'POST',
    data: formData,
   contentType: false,
   processData:false,
    success: function(data){
      alert('img'+data);
        if(data==1){
        alert("record inserted successfully "+data);

        }else if(data==0){
        alert("something went wrong! "+data);

        }else if(data==-1){
        alert("please enter valid values "+data);

        }else{
            alert(data);
        }
    }
});


});//form submission
}//if case
});
$('#reset').on('click',()=>{
$('#email-otp').hide();
$('#email-otp-btn').hide();
$('.otp-notify').html("");
$('#signup-btn').hide();


});



});

</script>

    
</body>
</html>
<?php
// include_once 'layout/footer.php';
?>