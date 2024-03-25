<link rel=stylesheet href='/front/css/modal.css' type='text/css'>
<linK rel=stylesheet href='/front/css/formdesign.css' type='text/css'>
<style>
    .form-container{
        width:500px;
    }
</style>
<?php include_once '../making_board/front/html/modal.html'; ?>
<?php
    $titleMsg = "";
    global $connect;
    // 입력검증
    
    $sql = "SELECT title,text FROM board WHERE id = '$boardID'";
    try{
        $stmt = $connect->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
    $title = $result["title"];
    $text = $result["text"];
    
?> 

<div class="form-container upd-form">
    <form id="posting-form" onsubmit="return false">
        <div class="form-group">
            <label for="title">Title</label>
            <input type = "text" id="upd-title" name = "title" <?php echo 'value="'.htmlspecialchars($title).'"';?> placeholder="제목을 입력해주세요">
        </div>
        <div class="form-group">
            <label for="text">Textarea</label>
            <textarea rows="10" cols="68" id="upd-text" name = "text" ><?php echo htmlspecialchars($text);?></textarea>
        </div>
        <input class="submit-btn crdbtn" id="posting-btn" type="button" value="수정">
    </form>
</div>
<script>
    $(".crdbtn").on("click",function(event){
        event.preventDefault();
        let beh = event.target.value;
        $("#chkp")[0].innerText = beh + "하시겠습니까?";
        $("#modal-overlay").css({"display":"flex"});//이거 토글로 만들까?
        $(".chkbtn").on("click",function(e){
            e.preventDefault();   
            let chk = chkbool(e.target.value);
            if(chk){
                let id = <?php echo $boardID?>;
                
                let title = $("#upd-title").val();
                let text = $("#upd-text").val();
                if(title){
                    const baseURL = "<?= BASE_URL?>/boards" + "/"+ id;
                    $.ajax({
                        type:"PUT",
                        url : baseURL,
                        data :{
                            
                            title : title,
                            text : text
                        },
                        dataType:'json',
                        success : function(result){      
                            console.log(result);      
                            // let rp = JSON.parse(result);
                            
                            const{mwResponse,deniedReason,serverResponse}=result;
                            console.log(mwResponse,deniedReason,serverResponse);
                            if(mwResponse===false){
                                console.log(deniedReason);
                                alert('권한이 없습니다');
                                return;
                            }
                            if(serverResponse){
                                alert('수정되었습니다');
                                window.location.replace(baseURL);
                            }else{
                                console.log(deniedReason);
                                alert('서버문제');
                            }
                            
                        },
                        error : function(xhr,status,error){
                            console.log("xhr: " + xhr);
                            console.log("status: " +status);
                            console.log("error :"+ error);
                        }
                    })
                }else{
                    $("#titleMsg")[0].innerText = "제목을 입력해주세요";
                    $("#modal-overlay").css({"display":"none"});
                }
            }else{
                $("#modal-overlay").css({"display":"none"});
            }
        })
    });
    $(".close").on("click",function(){
        $("#modal-overlay").css({"display":"none"});
    });
    function chkbool(string){
        if(string === "true"){
            return true;
        }else if(string === "false"){
            return false;
        }
    }
</script>
