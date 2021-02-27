<?php
    // function get_booking($pickup,$drop,$cabtype,$luggage,$total_fare,$total_distance,$customer_user_id){

        include 'dbcon.php';

        include 'classFile.php';

        $Dbcon_obj= new Dbcon();
        $tbl_user_obj=new Table_User();

        $tbl_ride_obj=new Table_Ride();
        $tbl_loc_obj=new Table_Location();


if(isset($_POST['action'])){

switch ($_POST['action']){
 


case 'get_booking' :///////////////////////

    if(isset($_POST['ride_data']) && $_POST['action']=='get_booking'){
        session_start();
        if(!isset($_SESSION['user'])){
            echo(-1);
        }else{
            $res_get_data = $tbl_ride_obj->get_booking($_POST['ride_data']['pickup'],$_POST['ride_data']['drop'],$_POST['ride_data']['cabtype'],$_POST['ride_data']['luggage'],$_POST['ride_data']['fare'],$_POST['ride_data']['distance'],$_SESSION['user']['user_id']);
            echo($res_get_data);    

        }

    }else{
        echo "oops";
    }


    break;
case 'get_details' :////////////////////////

    if(isset($_POST['action']) && $_POST['action']=='get_details'){
   
    $data=$tbl_ride_obj->get_details();
    print_r(json_encode($data));

    }else{
        echo(-1);
    }
    
    

    break;
    case 'pen_rides_adm' ://///////////////////////
        if(isset($_POST['action']) && $_POST['action']=='pen_rides_adm'){
   
            $data=$tbl_ride_obj->pen_rides_adm();
            print_r(json_encode($data));
        
            }else{
                echo(-1);
            }
    break;
    case 'pen_rides' ://///////////////////////
        if(isset($_POST['action']) && $_POST['action']=='pen_rides'){
   
            $data=$tbl_ride_obj->pen_rides();
            print_r(json_encode($data));
        
            }else{
                echo(-1);
            }

    break;
    case 'can_rides' ://///////////////////////
                if(isset($_POST['action']) && $_POST['action']=='can_rides'){
           
                    $data=$tbl_ride_obj->can_rides();
                    print_r(json_encode($data));
                
                    }else{
                        echo(-1);
                    }

    break;
    case 'com_rides' ://///////////////////////
                     if(isset($_POST['action']) && $_POST['action']=='com_rides'){
                           
                         $data=$tbl_ride_obj->com_rides();
                         print_r(json_encode($data));
                                
                    }else{
                        echo(-1);
                        }
    break;
    case 'com_rides_adm' ://///////////////////////
                    if(isset($_POST['action']) && $_POST['action']=='com_rides_adm'){
                                               
                         $data=$tbl_ride_obj->com_rides_adm();
                         print_r(json_encode($data));
                                                    
                    }else{
                       echo(-1);
                     }
    break;
    case 'total_rides' ://///////////////////////
                      if(isset($_POST['action']) && $_POST['action']=='total_rides'){
                                                   
                          $data=$tbl_ride_obj->total_rides();
                           print_r(json_encode($data));
                                                        
                        }else{
                            echo(-1);
                        }
                        

    break;
    case 'cancelRide' ://///////////////////////
                       if(isset($_POST['action']) && $_POST['action']=='cancelRide'){
                                                
                           $data=$tbl_ride_obj->cancelRide($_POST['rideId'],$_POST['cxId']);
                          
                               echo("cancelled successfully...");
                          
                                                                            
                                }else{
                                    echo(-1);
                                }
                                    
                                
    break;
    case 'viewDetails' ://///////////////////////
                       if(isset($_POST['action']) && $_POST['action']=='viewDetails'){
                           $data=$tbl_ride_obj->viewDetails($_POST['rideId'],$_POST['cxId']);
                           print_r(json_encode($data));
                                                                            
                                                                                                                               
                        }else{
                             echo(-1);
                            }
    break;
    case 'login' ://///////////////////////
                    if(isset($_POST['action']) && $_POST['action']=='login'){
                        if(isset($_POST['email']) && isset($_POST['password']) ){

                            $email= $_POST['email'];
                            $password=$_POST['password'];
                           
                            $obj=new Table_User();
                            // session_start();
                            echo ($obj->get_login($email,$password) );
                        
                           
                        }else{
                              echo false;
                             }   
                   } 
    break;
    case 'signup' ://///////////////////////
                   if(isset($_POST['action']) && $_POST['action']=='signup'){
                    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['password']) ){

                        $name=$_POST['name'];
                        $email= $_POST['email'];
                        $mobile=$_POST['mobile'];
                        $password=$_POST['password'];
                        // $pro_pic=$_FILES['pro_pic'];
                    
                        $file_name=$_FILES['pro_pic']['name'];
                        $file_tmp=$_FILES['pro_pic']['tmp_name'];
                        $file_type=$_FILES['pro_pic']['type'];
                        $file_path="assets/pro_pics/".$file_name;
                        move_uploaded_file($file_tmp,$file_path);
                    
                        $obj=new Table_User();
                        $flag=$obj->get_signup($name,$email,$mobile,$password,$file_path);
                        echo $flag;
                    
                    
                    }else{
                        echo(-1);
                    }
                    }                 

    break;
    case 'fareCalculate' ://///////////////////////
                        if(isset($_POST['action']) && $_POST['action']=='fareCalculate'){
                            if(isset($_POST['drop']) && isset($_POST['pickup']) && isset($_POST['cabtype']) && ($_POST['pickup']!=-1) && ($_POST['drop']!=-1) && ($_POST['cabtype']!=-1)){

                                // include 'cal_classFile.php';
                                $obj= new FareCalculate();
                                // How we can pass data
                                // cal_fare($distance,$cabtype,$luggage);
                                //  distance_check($pick,$drop)
                                ($_POST['luggage']=="") ? $_POST['luggage']=0 :$_POST['luggage']=$_POST['luggage']; 
                            
                                $distance=$obj->distance_check($_POST['pickup'],$_POST['drop']);
                                $fare=$obj->cal_fare($distance,$_POST['cabtype'],$_POST['luggage']);
                            
                            $response=[
                              'pickup'=>$_POST['pickup'],
                              'drop'=>$_POST['drop'],
                              'cabtype'=>$_POST['cabtype'],
                              'luggage'=>$_POST['luggage'],
                              'fare'=>$fare,
                              'distance' =>$distance
                            
                            ]; 
                            
                                
                                print_r(json_encode($response));
                               
                            }else{
                                echo -1;
                            }
                        }
                        
    break;
    case 'filter' ://///////////////////////
                   if(isset($_POST['action']) && $_POST['action']=='filter'){
                    if(isset($_POST['filterBy']) && isset($_POST['flag'])  ){

                       
                        $filterBy=$_POST['filterBy'];
                        $status=$_POST['flag'];
                     
                       
                        $obj=new Table_User();
                        $flag=$tbl_ride_obj->filter($filterBy,$status);
                        print_r(json_encode($flag));
                    
                    }else{
                        echo(-1);
                    }
                    } 
                    
    break;
    case 'get_details_adm' ://///////////////////////
                   if(isset($_POST['action']) && $_POST['action']=='get_details_adm'){
                                       
                     $data=$tbl_ride_obj->get_details_adm();
                     print_r(json_encode($data));
                                    
                   }else{
                     echo(-1);
                    }
                 


}//switch end

}//if isset end


?>