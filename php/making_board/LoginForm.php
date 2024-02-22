<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>
<body>
    
    <!--세션에 is_login 이 묶여있다면 로그아웃 버튼 보이게 -->
    <!--서버를 스탑했다가 다시 시작할 때 로그인이 유지가 되는 문제 -->
<?php
    session_start();
    
    if ((isset($_SESSION["is_loggedin"]) && $_SESSION["is_loggedin"])){
        header("Location: http://localhost:3000/boards");
    }    
    //로그인을 요청하면 userid와 userpw 를 입력했는지 확인 후 db에 select로 확인
    
    
?>
    <form action = "http://localhost:3000/login" method = "POST">
        ID : <input type= "text" name = "userid">
        PW : <input type= "password" name = "userpw">
        <input type= "submit">
    </form>
  
</body>
</html>