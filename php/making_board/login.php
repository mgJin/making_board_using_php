<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>
<body>
    <!--확인용 db 유저도 만들면 좋을듯?-->
<?php
    //로그인을 요청하면 userid와 userpw 를 입력했는지 확인 후 db에 select로 확인
    if(isset($_POST["userid"]) && isset($_POST["userpw"])){
        $userID = $_POST["userid"];
        $userPW = $_POST["userpw"];
     //DB 연결시작
        $servername = "localhost";
        $dbname = "phpboard";
        $user = "test1";
        $password = "1111";
        try{
            $connect = new PDO("mysql:host=$servername;dbname=$dbname",$user,$password);
            $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $ex){
            echo "DB연결실패".$ex->getMessage();
        }

        //exists 로 받아서 있으면 1, 없으면 0으로 결과나옴
        //근데 이런 방식으로 하면 pk 넘겨 받을 때 한번더 질의 해야하니깐 그냥 바로 pk 받아서 없으면 로그인 안되는 식으로
        // $sql = "SELECT EXISTS(SELECT * FROM member Where user_id = '$userID' and user_pw = '$userPW')as exist";
        // try{
        //     $stmt = $connect->query($sql);
        //     $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // }catch(PDOException $ex){
        //     echo "결과전송실패".$ex->getMessage();
        // }

        $sql = "SELECT user_pk FROM member WHERE user_id = '$userID' and user_pw = '$userPW'";
        try{
            $stmt = $connect->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            print_r($result);
        }catch(PDOException $ex){
            echo "결과전송실패".$ex->getMessage();
        }
        if(isset($result["user_pk"])){
            session_start();
            $_SESSION['userPK'] = $result["user_pk"]; //사용자의 pk session에 묶어서 넘김
            header("Location: http://localhost:3000/button.php");
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
    <button onclick="location.href='login.php'">버튼</button>
</body>
</html>