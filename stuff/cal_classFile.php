<?php


class FareCalculate 
{
    
    public $pick;
    public $drop;
    public $cabtype;
    public $luggage;
    // function __construct($pick){
    

    // }


    function distance_check($pick,$drop){
        include 'arrays.php';
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
// $obj= new FareCalculate('hellow');

// function cal_fare($distance,$cabtype,$luggage);
// function distance_check($pick,$drop)

?>