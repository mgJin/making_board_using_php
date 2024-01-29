<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <!-- 이제 퍼미션 제대로 작동하는지 확인하면 된다. -->
    
    <?php require('config.php');?>
    <?php include('EXP2.php');?>
    <?php
        $user_id = "testnewone";
        $sql = "SELECT user_id,role_id FROM member WHERE user_id = '$user_id' LIMIT 1";
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // var_dump($result);
        get_all_permissions($result);
    ?>
    <?php 
        //퍼미션을 가져오는 함수를 만들자 
        // function get_all_permissions($connect,$user){
            
        //     $role_id = $user["role_id"];
        //     $sql = "SELECT p.name as permisson FROM permission_role pr JOIN permissions p ON pr.permission_id = p.id WHERE pr.role_id= :role_id";
        //     $stmt = $connect->prepare($sql);
        //     $stmt ->bindParam(':role_id',$role_id);
        //     $stmt->execute();
        //     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //     var_dump($result);
        // }
    ?>
</body>
</html>