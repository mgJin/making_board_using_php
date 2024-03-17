
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indivisual User Page</title>
    <style>
        .info {
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 20px;
            width: 50%;
            position: relative; 
        }
        
        .info div {
            margin-bottom: 10px;
        }
        
        .info label {
            font-weight: bold;
        }
        
        .delete-button {
            background-color: #dc3545;
            color: #fff;
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            position: absolute;
            bottom: 5px;
            right: 5px;
        }
    </style>
</head>
<body>
    <?php 
        global $connect;

        $sql = "SELECT user_pk,user_id,name,gender,email,birth,role_id FROM member WHERE user_pk=:userPK LIMIT 1";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':userPK',$user_pk);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if(isset($userInfo["role_id"])):
            $sql = "SELECT name as role_name FROM roles WHERE id=:roleID";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':roleID',$userInfo["role_id"]);
            $stmt->execute();
            $roleInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        endif;

        // print_r($userInfo);  
    ?>
    <div class="info">
        <div>
            <label>ID:</label> <?php echo $userInfo["user_id"];?>
        </div>
        <div>
            <label>권한</label> <?php echo $userInfo["role_id"]?$roleInfo["role_name"]:"";?>
        </div>
        <div>
            <label>이름</label> <?php echo $userInfo["name"];?>
        </div>
        <div>
            <label>성별</label> <?php echo $userInfo["gender"];?>
        </div>
        <div>
            <label>이메일</label> <?php echo $userInfo["email"];?>
        </div>
        <div>
            <label>생일</label> <?php echo $userInfo["birth"];?>
        </div>
        <button class="delete-button" onclick="delfetch('<?= $userInfo['user_id']?>')">삭제</button>
    </div>
    <script>
        
        function delfetch(data){
            const formdata = {
                user_id : data,
                admin : true
            }
            fetch("http://localhost:3000/adminpage/usermanagement",{
                method:"DELETE",
                body:JSON.stringify(formdata)
            })
            .then(response=>response.json())
            .then(data=>console.log(data))
            .catch(error=>console.log(error));
        }
    </script>
</body>
</html>