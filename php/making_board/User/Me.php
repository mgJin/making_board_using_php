<link rel=stylesheet href='/front/css/modal.css'>
<style>
    .info{
        border: 1px solid #ddd;
        padding: 10px;
        margin-top: 20px;
        width: 50%;
        position: relative;
    }
    .info div{
        margin-bottom: 10px;
    }
    .info label{
        font-weight: bold;
    }
    .btn{
        color: #fff;
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
    }
    #upd-btn{
        background-color: coral;
    }
    #upd-btn:hover{
        background-color: #ffAB91;
    }
    #del-btn{
        background-color: #dc3545;
    }
    #del-btn:hover{
        background-color: #EF9A9A;
    }
</style>
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
<div class="info">
    <div>
        <label>ID:</label>
        <?php echo $result["user_id"]?>
    </div>
    <div>
        <label>Name:</label>
        <?php echo $result["name"]?>
    </div>
    <button id="upd-btn" class="btn">수정</button>
    <button id="del-btn" class="btn">탈퇴</button>
</div>
<!-- -->
<script>
    const updBtn = document.querySelector("#upd-btn");
    updBtn.addEventListener("click",function(){
        window.location.replace("<?= BASE_URL?>/me/updateform");
    })
    const delBtn = document.querySelector("#del-btn");
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

