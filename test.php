<?php
    $a=array(1,2,3,4);
    $b=array(10,20,30);
    $x=$a[count($a)-1];
    $y=$b[count($a)-count($b)];
   // echo $x;
    //echo $y;
    if ($x < $y){
        array_unshift($a,$b);
    }
    else{
        array_push($a,$b);
    }
    echo $a[5];
    echo $b[5];
    ?>