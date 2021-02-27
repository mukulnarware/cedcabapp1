<?php
include_once 'layout/header.php';
session_start();
if((isset($_SESSION['user']) && $_SESSION['user']['is_admin']==0)){

  echo "<h5 style='color: white; background:black;'>Welcome user : ".$_SESSION['user']['name']."</h5>";
  header('location:user/index.php');
 
}else if((isset($_SESSION['user']) && $_SESSION['user']['is_admin']==1)){
  echo "<h5 style='color: white; background:black;'>Welcome user : ".$_SESSION['user']['name']."</h5>";
  header('location:admin/index.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   
    <!-- <link rel="stylesheet" href="css/login.css"> -->
  <link rel="stylesheet" href="css/home.css">
    <title>login page</title>
</head>
<body>

<div class="container">
        
 <form id='login-form'>
  <h2>Login page</h2>
  <div>
    <label for="email" class='label'>Email</label>
    <input type="email" name='email' id="email" placeholder='Enter Email or username'>

  </div>
<input type='hidden' name='action' value='login'> 
<!-- // using it for the action page recognition -->

  <div>

    <label for="password" class='label' > Password</label>
    <input type="password" name='password' id="password" placeholder='Enter Password'>

  </div>

  
  
  <div>
          <button type='button' id='login-btn' class='btn'>Login</button>
          <button type='reset' id='reset' class='btn'>Reset</button>
        </div>
        
        <div id='createNewAccount-div'>
        <label for="">Create New Account</label>&nbsp<a href='signup.php'>SignUp</a>
        </div><div id='forgotPassword-div'>
        <label for="">Forgot Password</label>&nbsp<a href='#'>Click here</a>
        </div>
</form>
</div>
<script>
$(document).ready(()=>{ 
  // document.ready start


$('#login-btn').on('click',(e)=>{
e.preventDefault();
$.ajax({
    url: 'helper.php',
    type: 'POST',
    data: $('#login-form').serialize(),
    success: function(data){
            // alert(data);

        if(data==1){
        alert("Login successfully "+data);
        window.location.href='/AJAX/CED_CAB_APP/user/';

        }else if(data==0){
        alert("incorrect username/password! ");

        }else if(data==-1){
        alert("something went wrong"+data);

        }else if(data==-2){
        window.location.href='/AJAX/CED_CAB_APP/admin/';
            
        }
    }
});
})

}); //document.ready end


</script>

    
</body>

</html>
<?php
include_once 'layout/footer.php';
?>