<?php 
    global $connect;
    // session_start();//mw에서 이미 실행함
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
<form id="updateform" onsubmit="return false">
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
    
    const subbtn = document.querySelector("#subbtn");
    subbtn.addEventListener("click",function(){
        const pregender =document.querySelector("input[name='gender']:checked");
        const regender = pregender?pregender.value:"";
        const formData = {
        id: document.querySelector("input[name='id']").value,
        name: document.querySelector("input[name='name']").value,
        gender: regender,
        birth: document.querySelector("input[name='birth']").value,
        email: document.querySelector("input[name='email']").value
    };
        handleSubmit("http://localhost:3000/me",formData);
    })
    
    async function handleSubmit(url,data){
        try{
            const response = await fetch(url,{
                method:"PUT",
                headers:{
                    "Content-Type":"application/json"
                },
                body:JSON.stringify(data)
            })
            const result = await response.json();
            const {mwResponse,serverResponse,deniedReason}= result;
            if(mwResponse==false){
                alert('권한이 없습니다');
                return;
            }
            if(!serverResponse){
                alert(deniedReason);
            }else{
                alert('수정되었습니다');
                window.location.replace('http://localhost:3000/me');
            }
        }catch(error){
            console.log(error);
        }
    }
    
</script>
