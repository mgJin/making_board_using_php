<?php



include_once 'functions.php';
include_once 'middleware.php';
$routes = include_once 'routes.php';

//미들웨어를 여기서 실행을 시키고 리턴을 받은게 false면 return; 을 해서 종료를 시킨다.
if(!(chk())){
    echo "접근불가";
    return;
};
run($_SERVER['REQUEST_URI'],$routes);
?>