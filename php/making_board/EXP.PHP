<?php 
    include('EXP2.php');
    $result = false;
    $z = 2;
    $a = true;
    $method = "post";
    if($a){
        $array_method = [
            "post"=>af($z)
            ,
            "put"=>af($z)  
            ,
            "delete"=>af($z)
        ];
        var_dump($array_method[$method]);
        
    }
    
?>
