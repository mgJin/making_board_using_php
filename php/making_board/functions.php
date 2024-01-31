<?php

function run($url,$routes){
    
    $url = parse_url($url);
    $path = $url['path'];
    $path = substr($path,1);
    $path = explode("/",$path);
    // var_dump($path);
    foreach($path as $p){
        // echo $p;
        if(array_key_exists($p,$routes)===true){
            break;
        }
        if (array_key_exists($p,$routes)===false){
            return;
        }
    }
    foreach($path as $p){
        $routes =$routes[$p];
    }
    $callback = $routes;
    
    // $callback = $routes['login']['aa'];
    $params = [];
    if(!empty($url['query'])){
        parse_str($url['query'],$params);
    }
    $callback($params);
}
?>