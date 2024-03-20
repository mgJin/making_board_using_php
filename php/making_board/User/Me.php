<link rel=stylesheet href='/front/css/modal.css'>

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
    include(__DIR__.'/../front/html/modal.html');
?>
<h1><?php echo $result["user_id"]?></h1>
<span><?php echo $result["name"]?></span>
<button id="updBtn">수정</button>
<button id="delBtn">탈퇴</button>

<script>
    const updBtn = document.querySelector("#updBtn");
    updBtn.addEventListener("click",function(){
        window.location.replace("<?= BASE_URL?>/me/updateform");
    })
    const delBtn = document.querySelector("#delBtn");
    delBtn.addEventListener("click",function(){
        const chkp = document.querySelector("#chkp");
        chkp.innerText = '탈퇴하시겠습니까?';
        const modalOverlay = document.querySelector("#modal-overlay");
        modalOverlay.style.display="flex";
        const chkbtn = document.querySelector(".chkbtn");
        chkbtn.addEventListener("click",function(e){
            let chk = chkbool(e.target.value);
            e.preventDefault();
            if(chk){
                let data = {
                    user_id:<?php echo json_encode($user_id);?>
                };
                console.log(data);
                const baseURL = "<?= BASE_URL?>/me";
                delJSON(baseURL,data);
            }else{
                modalOverlay.style.display="none";
            }
        });
        const cl = document.querySelector(".close");
        cl.addEventListener("click",function(){
            modalOverlay.style.display="none";
        });
        
    })
    
    async function delJSON(url,data){
        try{
            const response = await fetch(url,{
                method:"DELETE",
                headers:{
                    "Content-Type":"application/json"
                },
                body:JSON.stringify(data)
            })
            const result = await response.json();
            if(result){
                console.log("성공",result);
                const {mwResponse,serverResponse,deniedReason}=result;
                
                if(mwResponse==false){
                    alert(deniedReason);
                    return;
                }
                if(!serverResponse){
                    alert(deniedReason);
                    return;
                }else{
                    alert('탈퇴되었습니다');
                    window.location.replace("<?= BASE_URL?>/boards");
                }

            }}
        catch(error){
            console.log("실패",error);
        }
    }
    function chkbool(string){
        if(string === "true"){
            return true;
        }else if(string === "false"){
            return false;
        }
    }
</script>

