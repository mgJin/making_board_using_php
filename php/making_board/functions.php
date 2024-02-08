<?php

function run($url,$routes){
    $matchFound = false;
    $url = parse_url($url);
    $requestURL = $url['path'];
    foreach($routes as $path=>$element){
        $path = "^".$path;
        $path = $path."$";
     
        if(preg_match("@".$path."@",$requestURL,$matches)){
            // echo "preg_match 의 path:".$path;
            //첫번째 인덱스를 지워서 내가 찾는것들만 남게 함
            array_shift($matches);
            //함수부르기
            call_user_func_array($element,$matches);
            $matchFound = True;
            break;
        }
    }
    if(!$matchFound){
        echo "요청 URL :".$requestURL;
        echo "에러띄우기 ,없는 페이지";
    }
    // if(array_key_exists($path,$routes)===false){
    //     echo $path;
    //     echo "없는 페이지";
    //     return;
    // }
    
     
    // $params = [];
    // if(!empty($url['query'])){
    //     parse_str($url['query'],$params);
    // }
    // $callback($params);
}
?>