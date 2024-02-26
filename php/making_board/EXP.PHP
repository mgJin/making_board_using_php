<?php 
    $url = "/boards";
    if(preg_match('/\/boards\/*([0-9]+)/',$url,$matches)){
        var_dump($matches);
    }else{
        echo "no";
    }
?>