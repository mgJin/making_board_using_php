<?php

function run($url,$routes){
    
    $url = parse_url($url);
    $path = $url['path'];

    if(array_key_exists($path,$routes)===false){
        echo "없는 페이지";
        return;
    }
    $callback = $routes[$path];
     
    $params = [];
    if(!empty($url['query'])){
        parse_str($url['query'],$params);
    }
    $callback($params);
}
?>