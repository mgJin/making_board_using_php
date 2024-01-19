<?php 
    session_start();
    $_SESSION = array();
    if(ini_get("session.use_cookies")){//ini 파일에서 cookies 사용하고 있는지 묻는 것
        $params = session_get_cookie_params();//현재 사용하고 있는 쿠키 정보 불러옴
        setcookie(session_name(),'',time()-42000,
            $params["path"], $params["domain"],
            $params["secure"],$params["httponly"]);
    }
    session_destroy();
    header("LOCATION:http://localhost:3000/view_all_board.php");
?>