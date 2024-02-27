<?php 
    $url = "/boards";
    if(preg_match('/^\/boards(?:\/(\d+))?$/',$url,$matches)){
        var_dump($matches);
    }else{
        echo "no";
    }
?>