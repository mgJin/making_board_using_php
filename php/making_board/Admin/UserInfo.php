
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indivisual User Page</title>
</head>
<body>
    <?php 
        global $connect;

        $sql = "SELECT user_id,name,gender,email,birth,role_id FROM member WHERE user_pk=:userPK LIMIT 1";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':userPK',$user_pk);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        print_r($userInfo);  
    ?>
    <!-- 정보 뿌리고 수정버튼 추가하고 삭제도 추가하면 될듯-->
</body>
</html>