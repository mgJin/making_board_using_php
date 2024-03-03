<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self</title>
</head>
<body>
    <?php
        // session_start(); //mw에서 이미 세션을 실행하고 거기서 이어졌기 때문에 필요없음
        $user_id = $_SESSION["user"]["user_id"];
        
        global $connect;
        $sql = "SELECT user_id,name,gender,birth,email From member Where user_id=:userID LIMIT 1";
        try{
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':userID',$user_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $ex){
            echo $ex->getMessage();
        }
        
    ?>
    <h1><?php echo $result["user_id"]?></h1>
    <span><?php echo $result["name"]?></span>
    <button id="updBtn">수정</button>
    <button>탈퇴</button>
    <script>
        const updBtn = document.querySelector("#updBtn");
        updBtn.addEventListener("click",function(){
            window.location.replace("http://localhost:3000/me/updateform");
        })
    </script>
</body>
</html>