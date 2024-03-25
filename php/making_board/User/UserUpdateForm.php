<link rel='stylesheet' href='/front/css/formdesign.css' type='text/css'>
<link rel='stylesheet' href='/front/css/formdesign_radio.css' type='text/css'>

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

<form class="form-container" id="updateform" onsubmit="return false">
    <div class="form-group">
        <label for="id">ID</label>
        <input type = "text" name="id" <?php echoValue($user->getID());?>>
    </div>
    <div class="form-group">
        <label for="name">이름</label>
        <input type = "text" name = "name" <?php echoValue($user->getName());?>>
    </div>
    <div class="form-group1">
        <label class="radio-label">성별</label>
        <div class="radio-container">

            <div class="radio-box">
                <p class="radio-content1">남성</p>
                <input type= "radio" class="radio-content" name= "gender" value='male'>
            </div>
            
            <div class="radio-box">
                <p class="radio-content2">여성</p>    
                <input type= "radio" class="radio-content" name= "gender" value='female'>
            </div>
        </div>  
    </div>
    <div class="form-group">
        <label for="birth">생일</label>
        <input type = "date" name= "birth" <?php echoValue($user->getBirth());?>>
    </div>
    <div class="form-group">
        <label for="email">이메일</label>
        <input type = "text" name="email" <?php echoValue($user->getEmail());?>>
    </div>
    <div class="btn-container">
        <button class="submit-btn" id="subbtn">수정</button>
    </div>
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
        handleSubmit("<?= BASE_URL?>/me",formData);
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
                window.location.replace('<?= BASE_URL?>/me');
            }
        }catch(error){
            console.log(error);
        }
    }
    
</script>
