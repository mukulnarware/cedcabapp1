<?php

class Dbcon{
  public $sql;
  public $servername = "localhost";
  public $username = "root";
  public $password = "";
  public $dbname = "cabdata";
  public $con;
    
 function __construct(){
     $this->servername = "localhost";
     $this->username = "root";
     $this->password = "";
     $this->dbname = "cabdata";
      $this->con = new mysqli($this->servername, $this->username, $this->password,$this->dbname);
    
  
  
  if($this->con->connect_error) {
      die("Connection failed: " . $con->connect_error);
    }
}  

}

/////
// $var = new Dbcon();

// $sql="select * from `tbl_ride`";
     
// if($result=$var->con->query($sql)) {    
    
    
//     echo true;
//     print_r($var->con);
    
    
//    }else{
//        echo false;
//    }






/////
class Table_User extends Dbcon{

    public $user_id;
    public $email_id;
    public $name;
    public $dateofsignup;
    // public $cabtype;
    public $profile_pic;
    public $mobile;
    public $status;  // 0 for blocked 1 for unblocked
    public $password;
    public $is_admin; // boolean type 1/0 

    // function __construct(){

    // }

// User login function
    function get_login($email,$password){
        $this->email_id=$email;
        $this->password=$password;
        $sql="SELECT * FROM `tbl_user` WHERE `email_id`='$this->email_id' AND `password`='$this->password'";
        
        $result=$this->con->query($sql);
        if($result->num_rows > 0) {   
            $result=$result->fetch_assoc();
           session_start();
           $_SESSION['user']['user_id']=$result['user_id'];
           $_SESSION['user']['email_id']=$result['email_id'];
           $_SESSION['user']['name']=$result['name'];
           $_SESSION['user']['dateofsignup']=$result['dateofsignup'];
           $_SESSION['user']['mobile']=$result['mobile'];
           $_SESSION['user']['is_admin']=$result['is_admin'];
          if($result['is_admin']==1){
              return (-2);
          }else{
              return (true);
          }
        


        
        }else{
                return false;
             }

    }
//////////////////

// User login function
function get_signup($name,$email,$mobile,$password,$profile_pic){


     $this->name=$name;
     $this->email_id=$email;
     $this->mobile=$mobile;
     $this->password=$password;
     $this->profile_pic=$profile_pic;
     
     $sql="INSERT INTO `tbl_user`(`email_id`, `name`, `mobile`, `status`, `password`,`profile_pic`) VALUES ('$this->email_id','$this->name','$this->mobile','1','$this->password','$this->profile_pic')";
     
     if($result=$this->con->query($sql)) {    
         
         
         return true;
         
         
        }else{
            return false;
        }
    }
        
        
    
    

}//class end

// Class for table ride

class Table_Ride extends Dbcon{

    public $ride_id;
    public $ride_date;
    public $from;
    public $to;
    public $cabtype;
    public $total_distance;
    public $luggage; 
    public $total_fare;
    public $status; // 1 for pending , 2 for complete & 0 for cancelled.It shows ride status
    public $customer_user_id;
 ///////////////////////////////////////////
    // getting details of ride
    function viewDetails($rideId,$cxId){
        session_start();
       $details;
            if(!isset($_SESSION['user'])){
           
                return(-1);
            }else{
    
                 // query for total pending rides
             $sql="SELECT * from `tbl_ride` WHERE `customer_user_id`='$cxId' AND `ride_id`='$rideId'";
             $res=$this->con->query($sql);
               if($res->num_rows > 0) {   
                 $res=$res->fetch_assoc();
                 return $res;
                }
                 
    
            }
    
        }
     ///////////////////////////////////////////
    // getting cancel ride
    function cancelRide($rideId,$cxId){
        session_start();
       $dataAfterCancel;
            if(!isset($_SESSION['user'])){
           
                return(-1);
            }else{
    
                 // query for total pending rides
             $sql="UPDATE `tbl_ride` SET `status`='0' WHERE `customer_user_id`='$cxId' AND `ride_id`='$rideId'";
             $res=$this->con->query($sql);
                   
    
            }
    
        }
    ///////////////////////////////////////////
    // getting pending rides details for tables
    function pen_rides(){
    session_start();
    $tpen_ride;
        if(!isset($_SESSION['user'])){
       
            return(-1);
        }else{

             // query for total pending rides
         $sql_pen_ride="SELECT *  FROM `tbl_ride` WHERE `customer_user_id`='".$_SESSION['user']['user_id']."' AND `status`='1' ";
         $res_tpr=$this->con->query($sql_pen_ride);

          if($res_tpr->num_rows > 0) {   
           
            $i = 0;
            while ( $row=$res_tpr->fetch_assoc()) {
            $this->tpen_ride[$i] = $row;
            ++$i;
            }
            return $this->tpen_ride;
        }else{
            return 0;
        }
        // "tpr"=>$this->tpen_ride,


        }

    }
  ///////////////////////////////////////////
    // getting cancelled rides details for tables
    function can_rides(){
        session_start();
        $tcan_ride;
            if(!isset($_SESSION['user'])){
           
                return(-1);
            }else{
    
                 // query for total pending rides
             $sql_can_ride="SELECT * FROM `tbl_ride` WHERE `customer_user_id`='".$_SESSION['user']['user_id']."' AND `status`='0' ";
            
             $res_tcr=$this->con->query($sql_can_ride);
                if($res_tcr->num_rows > 0) {   
               
                $i = 0;
                while ( $row=$res_tcr->fetch_assoc()) {
                $this->tcan_ride[$i] = $row;
                ++$i;
                }
                return $this->tcan_ride;
            }else{
                return 0;
            }
            // "tpr"=>$this->tcan_ride,
    
    
            }
    
        }
    
    
 ///////////////////////////////////////////
    // getting completed rides details for tables
    function com_rides(){
        session_start();
        $tcom_ride;
            if(!isset($_SESSION['user'])){
           
                return(-1);
            }else{
    
                 // query for total pending rides
             $sql_com_ride="SELECT * FROM `tbl_ride` WHERE `customer_user_id`='".$_SESSION['user']['user_id']."' AND `status`='2' ";
        
             $res_tcomr=$this->con->query($sql_com_ride);
                if($res_tcomr->num_rows > 0) {   
               
                $i = 0;
                while ( $row=$res_tcomr->fetch_assoc()) {
                $this->tcom_ride[$i] = $row;
                ++$i;
                }
                return $this->tcom_ride;
            }else{
                return 0;
            }
            // "tpr"=>$this->tcan_ride,
    
    
            }
    
        }

         ///////////////////////////////////////////
    // getting completed rides details for tables
    function total_rides(){
        session_start();
        $atot_ride;
            if(!isset($_SESSION['user'])){
           
                return(-1);
            }else{
    
                 // query for total pending rides
                 $sql_all_tot_ride="SELECT * FROM `tbl_ride` WHERE `customer_user_id`='".$_SESSION['user']['user_id']."'";
                 $res_atr=$this->con->query($sql_all_tot_ride);
          
                if($res_atr->num_rows > 0) {   
               
                $i = 0;
                while ( $row=$res_atr->fetch_assoc()) {
                $this->atot_ride[$i] = $row;
                ++$i;
                }
                return $this->atot_ride;
            }else{
                return 0;
            }
            // "tpr"=>$this->tcan_ride,
    
    
            }
    
        }


    //////////get all the details
function get_details(){
    $response;
    session_start();
    if(!isset($_SESSION['user'])){
       
        return(-1);
    }else{
        // query for pending rides
        $sql_pen_ride="SELECT count(`ride_id`) as `pending_ride` FROM `tbl_ride` WHERE `customer_user_id`='".$_SESSION['user']['user_id']."' AND `status`='1' ";
        $res_pr=$this->con->query($sql_pen_ride);
        
         // query for cancelled rides
         $sql_can_ride="SELECT count(`ride_id`) as `cancelled_ride` FROM `tbl_ride` WHERE `customer_user_id`='".$_SESSION['user']['user_id']."' AND `status`='0' ";
         $res_cr=$this->con->query($sql_can_ride);
         

         // query for total spent
         $sql_tot_spent="SELECT sum(`total_fare`) as `total_spent` FROM `tbl_ride` WHERE `customer_user_id`='".$_SESSION['user']['user_id']."' AND `status`='2' ";
         $res_ts=$this->con->query($sql_tot_spent);
         
          // query for total rides
          $sql_tot_ride="SELECT count(`ride_id`) as `total_ride` FROM `tbl_ride` WHERE `customer_user_id`='".$_SESSION['user']['user_id']."'";
          $res_tr=$this->con->query($sql_tot_ride);
         

////////////////////////////////////////////
        if($res_pr->num_rows > 0) {   
            $res_pr=$res_pr->fetch_assoc();
            // return $res_pr['pending_ride'];
        }
        
//////////////////////////////////////////
        if($res_cr->num_rows > 0) {   
            $res_cr=$res_cr->fetch_assoc();
            // return $res_cr['cancelled_ride'];
        }
   
//////////////////////////////////////////
        if($res_ts->num_rows >0) {   
            $res_ts=$res_ts->fetch_assoc();
            // return $res_ts['total_spent'];
        } 
   
  //////////////////////////////////////////////////
        if($res_tr->num_rows > 0) {   
            $res_tr=$res_tr->fetch_assoc();
            // return $res_tr['total_ride'];
        }
 
/////////////////////////////////////////////
return ($response=[ "pen_ride"=>$res_pr['pending_ride'],"can_ride"=> $res_cr['cancelled_ride'], "tot_spent" => $res_ts['total_spent'],"tot_ride" =>$res_tr['total_ride']  ]);
/////////
    }

}//get details func

/////////// booking function_
    function get_booking($pickup,$drop,$cabtype,$luggage,$total_fare,$total_distance,$customer_user_id){
        if(!isset($_SESSION['user'])){
            echo(-1);
        }else{
        $this->from=$pickup;
        $this->to=$drop;
        $this->customer_user_id=$customer_user_id;
        $this->cabtype=$cabtype;
        $this->luggage=$luggage;
        $this->total_fare=$total_fare;
        $this->total_distance=$total_distance;

       
    $sql="INSERT INTO `tbl_ride`(`ride_date`, `from`, `to`, `total_distance`, `cabtype`, `luggage`, `total_fare`, `status`, `customer_user_id`) VALUES (now(),'$pickup','$drop','$total_distance','$cabtype','$luggage','$total_fare','1',".$_SESSION['user']['user_id'].")";

          
     if($result=$this->con->query($sql)) {    
                
        return (true);
        
       }else{
           return false;
       }
   }


    }

    
}


// Class for table location

class Table_Location{

    public $id;
    public $name;
    public $distance;
    public $is_available; //boolean
   

    function __construct(){
        
    }


}


//////////////////////fare calculation class//////////////////////////////////////////////////

class FareCalculate 
{
    
    public $pick;
    public $drop;
    public $cabtype;
    public $luggage;
    // function __construct($pick){
    

    // }


    function distance_check($pick,$drop){
        include 'layout/arrays.php';
        $this->pick=$pick;
        $this->drop=$drop;
        
        return abs($locations[$pick]-$locations[$drop]);
    }

     
    
function cal_fare($distance,$cabtype,$luggage){
    $this->cabtype=$cabtype;
    $this->luggage=$luggage;

    $sd=160;

    switch ($cabtype){

    case 'CedMicro':
        $fixedFare=50;
        $lugg_fare=0;
        if($distance>=$sd)
         {
             $dist_fare=(10*13.50)+(50*12)+(100*10.20)+(($distance-$sd)*8.50);
         }else if($distance<$sd)
                    {
                        if($distance>=60 && $distance<160){
                            $dist_fare=(10*13.50)+(50*12)+(abs($distance-60)*10.20);

                        }
                        if($distance>=10 && $distance<60){
                            $dist_fare=(10*13.50)+(abs($distance-10)*12);

                        }
                        if($distance>=0 && $distance<10){
                            $dist_fare=(10*13.50);

                        }
                    }
                    $dist_fare+=($fixedFare+$lugg_fare);


        break;

    case 'CedMini':
        $fixedFare=150;
        // // for luggage calculations
        if($luggage<=10){  $lugg_fare=50; }
        else if($luggage>10 && $luggage<=20){  $lugg_fare=100; }
        else if($luggage>20){$lugg_fare=200; }

        // // for distance calculations

        if($distance>=$sd)
         {
             $dist_fare=(10*14.50)+(50*13.0)+(100*11.20)+(($distance-$sd)*9.50);
         }else if($distance<$sd)
                    {
                        if($distance>=60 && $distance<160){
                            $dist_fare=(10*14.50)+(50*13.0)+(abs($distance-60)*11.20);

                        }
                        if($distance>=10 && $distance<60){
                            $dist_fare=(10*14.50)+(abs($distance-10)*13.0);

                        }
                        if($distance>=0 && $distance<10){
                            $dist_fare=(10*14.50);

                        }
                    }
                    $dist_fare+=($fixedFare+$lugg_fare);


        break;
    case 'CedRoyal':
        $fixedFare=200;
        // for luggage calculations
        if($luggage<=10){  $lugg_fare=50; }
        else if($luggage>10 && $luggage<=20){  $lugg_fare=100; }
        else if($luggage>20){$lugg_fare=200; }
        // for distance fare calculations

        if($distance>=$sd)
         {
             $dist_fare=(10*15.50)+(50*14.0)+(100*12.20)+(($distance-$sd)*10.50);
         }else if($distance<$sd)
                    {
                        if($distance>=60 && $distance<160){
                            $dist_fare=(10*15.50)+(50*14.0)+(abs($distance-60)*12.20);

                        }
                        if($distance>=10 && $distance<60){
                            $dist_fare=(10*15.50)+(abs($distance-10)*14.0);

                        }
                        if($distance>=0 && $distance<10){
                            $dist_fare=(10*15.50);

                        }
                    }
                    $dist_fare+=($fixedFare+$lugg_fare);


        break;
    case 'CedSUV':
        $fixedFare=250;
        // // for luggage calculations
        if($luggage<=10){  $lugg_fare=50*2; }
        else if($luggage>10 && $luggage<=20){  $lugg_fare=100*2; }
        else if($luggage>20){$lugg_fare=200*2; }

        if($distance>=$sd)
         {
             $dist_fare=(10*16.50)+(50*15.0)+(100*13.20)+(($distance-$sd)*11.50);
         }else if($distance<$sd)
                    {
                        if($distance>=60 && $distance<160){
                            $dist_fare=(10*16.50)+(50*15.0)+(abs($distance-60)*13.20);

                        }
                        if($distance>=10 && $distance<60){
                            $dist_fare=(10*16.50)+(abs($distance-10)*15.0);

                        }
                        if($distance>=0 && $distance<10){
                            $dist_fare=(10*16.50);

                        }
                    }
                    $dist_fare+=($fixedFare+$lugg_fare);


        break;




    }
    return $dist_fare;
}




}







?>