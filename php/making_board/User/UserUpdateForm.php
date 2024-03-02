

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php 
        global $connect;
        session_start();
        $userID = $_SESSION["user"]["user_id"];
        $sql = "SELECT user_id,name,gender,birth,email FROM member WHERE user_id=:userID";
        try{
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(":userID",$userID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $ex){
            echo $ex->getMessage();
        }
        require('UserBuilder.php');
        $user = USER::builder()
        ->valID($result["user_id"])
        ->valName($result["name"])
        ->valGender($result["gender"])
        ->valBirth($result["birth"])
        ->valEmail($result["email"])
        ->build();
    ?>
    <!-- 비밀번호 바꾸는건 따로 페이지를 만들어서 하자-->
    <form id="signform" onsubmit="return false">
        ID : <input type = "text" name="id" <?php echoValue($user->getID());?>>
        
        이름 : <input type = "text" name = "name" <?php echoValue($user->getName());?>>
        
        Gender : <input type= "radio" name= "gender" value='male'>남자
                 <input type= "radio" name= "gender" value='female'>여자
        birth : <input type = "date" name= "birth" <?php echoValue($user->getBirth());?>>
        
        email : <input type = "text" name="email" <?php echoValue($user->getEmail());?>>
        
        <button id="subbtn">수정</button>
    </form>
    <script>
        const getGender = "<?php echo htmlspecialchars($user->getGender());?>";
        const genderRadio = document.querySelector('input[name="gender"][value="'+getGender+'"');
        if(genderRadio){
            genderRadio.checked = true;
        }
        
    </script>
</body>
</html>