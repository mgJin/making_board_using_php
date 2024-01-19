<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>
<body>
    <!--확인용 db 유저도 만들면 좋을듯?-->
    <!--세션에 is_login 이 묶여있다면 로그아웃 버튼 보이게 -->
    <!--서버를 스탑했다가 다시 시작할 때 로그인이 유지가 되는 문제 -->
<?php
    session_start();
    if ((isset($_SESSION["is_loggedin"]) && $_SESSION["is_loggedin"])){
        header("Location: http://localhost:3000/view_all_board.php");
    }    
    //로그인을 요청하면 userid와 userpw 를 입력했는지 확인 후 db에 select로 확인

    if(isset($_POST["userid"]) && isset($_POST["userpw"])){
        $userID = $_POST["userid"];
        $userPW = $_POST["userpw"];
     //DB 연결시작
        require_once('dbconnect_root.php');
            //로그인 성공 시 connect 도 userid 로 된 것을 만들어서 전역변수처럼?
            //원래 실험하고 싶었던 것은 여기서 connect를 만들고 다른 곳에서 전역변수처럼 사용할 수 있나?

        $sql = "SELECT user_id,name FROM member WHERE user_id = '$userID' and user_pw = '$userPW'";
        try{
            $stmt = $connect->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            var_dump($result);
        }catch(PDOException $ex){
            echo "결과전송실패".$ex->getMessage();
        }
        if(isset($result["user_id"])){
            session_start();
            $_SESSION["is_loggedin"] = True;
            $_SESSION["user"] = $result; //사용자의 정보 session에 묶어서 넘김
            header("Location: http://localhost:3000/view_all_board.php");
        }else{
           echo "<script>alert('ID와 PW를 다시 확인해 주세요')</script>";
        
        }

    }
?>
    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST">
        ID : <input type= "text" name = "userid">
        PW : <input type= "password" name = "userpw">
        <input type= "submit">
    </form>
  
</body>
</html>