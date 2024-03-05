<?php

include_once (__DIR__.'/Common/functions.php');
include_once (__DIR__.'/Common/middleware.php');
$routes = include_once (__DIR__.'/Settings/routes.php');

//미들웨어를 여기서 실행을 시키고 리턴을 받은게 false면 return; 을 해서 종료를 시킨다.
// echo "<script>1onsole.log('BeforeMW')</script>";
if(!(chk())){
    return;
};

// include(__DIR__.'/../making_board/EXP3.php');

    // header('Content-Type:application/json');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>
<body>
    <header>
        <h1>Header Area</h1>
    </header>
    <main>
        <?php run($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_METHOD'],$routes);?>
    </main>
</body>
</html>