<?php 
    if(isset($_POST["userid"]) && isset($_POST["userpw"])){
        $userID = $_POST["userid"];
        $userPW = $_POST["userpw"];
     //DB 연결시작
        require('config.php');
            //로그인 성공 시 connect 도 userid 로 된 것을 만들어서 전역변수처럼?
            //원래 실험하고 싶었던 것은 여기서 connect를 만들고 다른 곳에서 전역변수처럼 사용할 수 있나?

        $sql = "SELECT user_id,name FROM member WHERE user_id = '$userID' and user_pw = '$userPW'";
        try{
            $stmt = $connect->prepare($sql);
            $stmt ->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            var_dump($result);
        }catch(PDOException $ex){
            echo "결과전송실패".$ex->getMessage();
        }
        if(isset($result["user_id"])){
            
            $_SESSION["is_loggedin"] = True;
            $_SESSION["user"] = $result; //사용자의 정보 session에 묶어서 넘김
            header("Location: http://localhost:3000/board");
        }else{
           echo "<script>alert('ID와 PW를 다시 확인해 주세요')</script>";
        
        }

    }
?>