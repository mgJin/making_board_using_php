
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

        try{
            $sql = "SELECT name FROM roles";
            $stmt = $connect->prepare($sql);
            $stmt->execute();
            $roleNames = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }catch(PDOException $ex){
            echo $ex->getMessage();
        }

        // print_r($userInfo);  
    ?>
    <div class="info">
        <div>
            <label>ID:</label> <?= $userInfo["user_id"];?>
        </div>
        <div>
            <label>권한</label> 
            <select>
                <?php foreach($roleNames as $roleName):?>
                    <option class="option-role" value="<?= $roleName?>"><?= $roleName?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div>
            <label>이름</label> <?= $userInfo["name"];?>
        </div>
        <div>
            <label>성별</label> <?= $userInfo["gender"];?>
        </div>
        <div>
            <label>이메일</label> <?= $userInfo["email"];?>
        </div>
        <div>
            <label>생일</label> <?= $userInfo["birth"];?>
        </div>
        <button id="upd-btn">권한 수정</button>
        <button class="delete-button" onclick="delfetch('<?= $userInfo['user_id']?>')">삭제</button>
    </div>
    <script>
        const options = document.querySelectorAll(".option-role");
        options.forEach(function(option,index){
            if(option.value=='<?= isset($roleInfo["role_name"])?($roleInfo["role_name"]):""?>'){
                option.selected = true;
            }
        })
        const updbtn = document.querySelector("#upd-btn");
        updbtn.addEventListener("click",async function(){
            for(var i=0;i<options.length;i++){
                if(options[i].selected){
                    let formData = {
                        optionValue : options[i].value
                    }
                    await fetch("http://localhost:3000/adminpage/userinfo/"+<?= $user_pk?>,{
                        method:"PUT",
                        body:JSON.stringify(formData)
                    })
                    .then(response=>response.json())
                    .then(data=>console.log(data))
                    .catch(error=>console.log(error));

                    break;
                }
            }
        });
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