<?php

function run($url,$routes){
    
    $url = parse_url($url);
    $path = $url['path'];
    $path = substr($path,1);
    $path = explode("/",$path);
    // var_dump($path);
    // var_dump($routes[0]->{'children'});
    //   /main/dd 라고 가정, path 에는 / , main, dd 가 들어가 있다
    $result = (object)array();
    foreach($path as $p){
        $pass = false;
        // if(gettype($routes)!="array"){
        //     echo "없는 페이지";
        //     return;
        // }
        // if(array_key_exists($p,$routes)===false){
        //     echo "없는 페이지";
        //     return;
        // }
        foreach($routes as $route){
            if($route->{'path'}==$p){
                $pass= true;
                continue;        
            }
        }
        if((!(end($path)==$p))&&$pass){
            $routes = $route->{'children'};
        }else if((end($path)==$p)&&$pass){
            $result = $route;
        }
    }
    $callback = $result->{'source'};
    $callback();
    // $callback = $routes;
    
    // // $callback = $routes['login']['aa'];
    // $params = [];
    // if(!empty($url['query'])){
    //     parse_str($url['query'],$params);
    // }
    // $callback($params);
}
?>