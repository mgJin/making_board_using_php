<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>업데이트Form</title>
        <link rel=stylesheet href='/front/css/modal.css' type='text/css'>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    </head>
<body>
    <?php include_once '../making_board/front/html/modal.html'; ?>
    <?php
        $titleMsg = "";
        global $connect;
        // 입력검증
        
        $sql = "SELECT title,text FROM board WHERE id = '$board_id'";
        try{
            $stmt = $connect->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $ex){
            echo $ex->getMessage();
        }
        $title = $result["title"];
        $text = $result["text"];
        
    ?> 
    <form class="upd-form">
        제목 : <input type = "text" id="upd-title" name = "title" <?php echo 'value="'.htmlspecialchars($title).'"';?> placeholder="제목을 입력해주세요">
        <p id="titleMsg"></p>
        내용 : <input type = "text" id="upd-text" name = "text" <?php echo 'value="'.htmlspecialchars($text).'"';?>>
        <input type="hidden" id= "upd-id" name="board_id" value = <?php echo $board_id?>>
        <input class="crdbtn" type = "button" value="수정">
    </form>
    
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
                    let id = $("#upd-id").val();
                    let title = $("#upd-title").val();
                    let text = $("#upd-text").val();
                    if(title){
                        const baseURL = "http://localhost:3000/boards" + "/"+ id;
                        $.ajax({
                            type:"PUT",
                            url : baseURL,
                            data :{
                                id : id,
                                title : title,
                                text : text
                            },
                            dataType:'json',
                            success : function(result){      
                                console.log(result);      
                                // let rp = JSON.parse(result);
                                
                                const{mwResponse,deniedReason,serverResponse,exMsg}=result;
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
</body>
</html>