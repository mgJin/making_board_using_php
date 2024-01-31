<?php

function run($url,$routes){
    
    $url = parse_url($url);
    $path = $url['path'];
    $path = substr($path,1);
    $path = explode("/",$path);
    var_dump($path);
    foreach($path as $p){
        if (array_key_exists($p,$routes)===false){
            return;
        }
    }

    $callback = $routes[$path];
    $params = [];
    if(!empty($url['query'])){
        parse_str($url['query'],$params);
    }
    $callback($params);
}
?>