<?php

include_once (__DIR__.'/Common/functions.php');
include_once (__DIR__.'/Common/middleware.php');
$routes = include_once (__DIR__.'/Settings/routes.php');

//미들웨어를 여기서 실행을 시키고 리턴을 받은게 false면 return; 을 해서 종료를 시킨다.
//return false가 되면 boards 페이지로 보내는게 제일 좋을듯?
if(!(chk())){
    return;
};

// include(__DIR__.'/../making_board/EXP3.php');
if($_SERVER['REQUEST_METHOD']!="GET"):
    run($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_METHOD'],$routes);
    return;
endif;
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
        footer{
            clear:both;
        }
    </style>
</head>
<body>
    <header>
        <h1>Header Area</h1>
    </header>
    <main>
        <?php run($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_METHOD'],$routes);?>
    </main>
    <footer>
        <h1>Footer Area</h1>
    </footer>
</body>
</html>