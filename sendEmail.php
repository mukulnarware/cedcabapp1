<?php



session_start(); 
use PHPMailer\PHPMailer\PHPMailer;
$otp=rand(1001,9999);
$_SESSION['otp']=$otp;
// $_SESSION['user-data']=$_POST;

if(isset($_POST['name']) && isset($_POST['email'])){
include 'dbcon.php';

$sql="SELECT * FROM `tbl_user` WHERE `email_id`='".$_POST['email']."'";
$result=$con->query($sql);

if(!($result->num_rows > 0)){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $_SESSION['email']=$email;
    $_SESSION['user_verified']=false;
    
    $otpMessage="Hello $name, <br>This is your four digit OTP  : <b>$otp</b> to verify";

    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();

    //smtp settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "mukul.cedcoss@gmail.com";
    $mail->Password = '9340663997M';
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";

    //email settings
    $mail->isHTML(true);
    $mail->setFrom($email, $name);
    $mail->addAddress($email);
    $mail->Subject = ("$email ($name)");
    $mail->Body = $otpMessage;

    if($mail->send()){
        $status = "success";
        $response = "Email is sent!";
        $_SESSION['user_verified']=true;
    }
    else
    {
        $status = "failed";
        $response = "Something is wrong: <br>" . $mail->ErrorInfo;
    }
    if($_SESSION['user_verified']==true) {
        echo(1);
    }   
    else{
        echo(0);
    }
    // exit(json_encode(array("status" => $status, "response" => $response)));

} //  checking num rows


else{
    echo(-1);
}
////////////////////////////program for sms sending
}

?>














      