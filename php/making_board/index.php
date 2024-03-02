<?php



include_once (__DIR__.'/Common/functions.php');
include_once (__DIR__.'/Common/middleware.php');
$routes = include_once (__DIR__.'/Settings/routes.php');

//미들웨어를 여기서 실행을 시키고 리턴을 받은게 false면 return; 을 해서 종료를 시킨다.
if(!(chk())){
    return;
};

run($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_METHOD'],$routes);
?>
