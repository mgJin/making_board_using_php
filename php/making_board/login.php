<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>
<body>
<?php
    //로그인을 요청하면 userid와 userpw 를 입력했는지 확인 후 db에 select로 확인
    if(isset($_POST["userid"]) && isset($_POST["userpassword"])){
        $userID = $_POST["userid"];
        $userPW = $_POST["userpassword"];
     //DB 연결시작
        $servername = "localhost";
        $dbname = "phpboard";
        $user = "test1";
        $password = "1111";
        try{
            $connect = new PDO("mysql:host=$servername;dbname=$dbname",$user,$password);
            $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            echo "DB연결 성공";
        }catch(PDOException $ex){
            echo "DB연결실패".$ex->getMessage();
        }

        //exists 로 받아서 있으면 1, 없으면 0으로 결과나옴
        $sql = "SELECT EXISTS(SELECT * FROM member Where id = '$userID' and password = '$userPW')as exist";
        try{
            $stmt = $connect->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            print_r($result);
        }catch(PDOException $ex){
            echo "결과전송실패".$ex->getMessage();
        }
        if($result["exist"]){
            session_start();
            echo $userID;
            $_SESSION['userID'] = $userID; //사용자의 id session에 묶어서 넘김
        }else{
           echo "<script>alert('ID와 PW를 다시 확인해 주세요')</script>";
        }

    }
?>
    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST">
        ID : <input type= "text" name = "userid">
        PW : <input type= "password" name = "userpassword">
        <input type= "submit">
    </form>
    <button onclick="location.href='login.php'">버튼</button>
</body>
</html>