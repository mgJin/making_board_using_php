<?php

function run($url,$method,$routes){
    //라우터에 요청한 페이지가 있는지 여부에 대한 변수
    $matchFound = false;
    $url = parse_url($url);
    $requestURL = $url['path'];
    //method 를 소문자로(route에 다 소문자로 만들어 놓았다.)
    $method = strtolower($method);
    
    //method 도 받아서 element[method] 이런식으로 가게 하면 될듯
    foreach($routes as $path=>$element){
        $path = "^".$path;
        $path = $path."$";
     
        if(preg_match("@".$path."@",$requestURL,$matches)){
            // echo "preg_match 의 path:".$path;
            //첫번째 인덱스를 지워서 내가 찾는것들만 남게 함
            array_shift($matches);
            //들어온 메서드에 해당하는 라우트가 있는지 확인
            if(!array_key_exists($method,$element)){
                break;
            }
            //함수부르기
            call_user_func_array($element[$method],$matches);
            $matchFound = True;
            break;
        }
    }
    if(!$matchFound){
        echo "요청 URL :".$requestURL;
        echo "에러띄우기 ,없는 페이지";
    }
    
}
?>