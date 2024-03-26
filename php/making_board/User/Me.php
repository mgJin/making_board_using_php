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
    .nav-li{
        padding:5px;
        list-style: none;
        display: inline-block;
        cursor: pointer;
    }
    .nav-li:hover{
        font-weight: bold;
    }
    #non-result{
        text-align: center;
    }
    .board a{
        text-decoration: none;
    }
    .board span{
        float:right;
    }
    .btn-container{
        
        position:absolute;
        margin-top:10px;
        bottom:0px;
        right:10px;

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
    .disabled{
        display:none;
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
    $sql = "SELECT id,title,text,created FROM board WHERE writer=:userID";
    try{
        $stmt=$connect->prepare($sql);
        $stmt->bindParam(':userID',$user_id);
        $stmt->execute();
        $boardResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
    include(__DIR__.'/../front/html/modal.html');
?>
<div>
    <nav>
        <ol class="Me-ol">
            <li class="nav-li" onclick="navclick('#profile')">
                프로필    
            </li>
            <li class="nav-li" onclick="navclick('#posts')">
                내 게시글
            </li>
        </ol>
    </nav>
</div>
<div id="profile" class="info">
    <div>
        <label>ID:</label>
        <?php echo $result["user_id"]?>
    </div>
    <div>
        <label>Name:</label>
        <?php echo $result["name"]?>
    </div>
    <div class="btn-container">
        <button id="upd-btn" class="btn">수정</button>
        <button id="del-btn" class="btn">탈퇴</button>
    </div>
</div>
<div id="posts" class="info">
    <?php if(count($boardResults)>0):?>
        <div class="boards-box">
            <?php foreach($boardResults as $index=>$contents):?>
                <div class="board">
                    <a href="<?= BASE_URL.'/boards/'.$contents['id']?>">
                        <?= $contents['title']?>
                    </a>
                    <span><?= $contents['created']?></span>
                </div>
            <?php endforeach;?>
        </div>
    <?php else:?>
        <div class="boards-box">
            <p id="non-result">
                게시물이 없습니다.
            </p>
        </div>
    <?php endif;?>
</div>

<!-- -->
<script>
    //새로고침 시 프로필 화면이 뜨도록
    window.addEventListener('DOMContentLoaded',function(){
        navclick("#profile");
    })
    //navclick 시 해당 정보만 뜨는 함수
    function navclick(target){
        document.querySelectorAll(".info").forEach(function(element){
            element.classList.add("disabled");
        })
        let infoclass = document.querySelector(target);
        infoclass.classList.remove("disabled");
    }
    //update버튼 이벤트
    //updateform 으로 이동
    const updBtn = document.querySelector("#upd-btn");
    updBtn.addEventListener("click",function(){
        window.location.replace("<?= BASE_URL?>/me/updateform");
    })
    //delete버튼 이벤트
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
    //delete 요청
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

