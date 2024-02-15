<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 보기</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link rel=stylesheet href='/front/css/modal.css' type='text/css'>
</head>

<body>
    <!--권한 제한된 유저를 만들어서 그놈이 보는걸로 -->
    <!--삭제 버튼 누를 때 권한 확인 필요-->
    <!--게시판 아이디 없이 들어오면 전체 게시판으로 -->
    <?php 
        include_once('../making_board/front/html/modal.html');
    ?>
    <?php 
        global $connect;
        //$var 는 route에서 받은 것
        $board_id = $var;
        $sql = "SELECT title,text,writer FROM board WHERE id = $board_id";
        $stmt = $connect->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$result){
            //error 띄우기(404)
            echo "<h1>404 NOT FOUND</h1>";
            return;
        }
    ?>
   
    <div>
        <h2>제목 : <?php echo $result["title"] ?></h2>
        <span>작성자 : <?php echo $result["writer"]?></span>
        <br>
        <span><?php echo $result["text"]?></span>
    </div>
    
        <button class="crdbtn" id="updbtn" value=<?php echo $board_id?>>수정</button>
        <button class="crdbtn" id="delbtn" value=<?php echo $board_id?>>삭제</button>
    
    
    <script>
        //수정을 누르면 수정 페이지가 나오고 거기서 폼 입력받은걸로 해야함
         $(".crdbtn").on("click",function(event){
            $("#chkp")[0].innerText = event.target.innerText + "하시겠습니까?";
            $("#modal-overlay").css({"display":"flex"});
            $(".chkbtn").on("click",{action:event.target.innerText,id:event.target.value},function(e){ 
            let chk = chkbool(e.target.value);
            e.preventDefault();
            if(chk){
                let action = chkbeh(e.data.action);
                console.log(action);
                let board_id = <?php echo $var?>;
                const baseURL = "http://localhost:3000/board";
                const boardURL = baseURL + "/" + board_id;
                if(action==="delete"){
                    let fullURL = boardURL + "/" + action;
                    $.ajax({
                        type: "POST",
                        url : fullURL,
                        data : {
                                'cud-action' : 'delete-board'
                               },
                        success : function(result){
                            let r = result.replace(/}{/g,',');
                            console.log(r);
                            let rp = JSON.parse(r);
                            const {mwResponse,serverResponse,exMsg} = rp;
                            console.log(mwResponse,serverResponse);
                            if(!mwResponse){
                                alert("권한이 없습니다.");
                                window.location.replace(boardURL);
                            }else{
                                if(!serverResponse){
                                    console.log("문제 : " +exMsg);
                                    alert('서버 문제');
                                }else{
                                    alert(event.target.innerText+"되었습니다.");
                                    window.location.replace(baseURL);
                                }
                            }
                        },
                        error : function(request,status,error){
                            console.log(error);
                        }
                    });
                }else if(action==="update"){
                    let fullURL = boardURL + "/" + action+"Form";
                   
                    $("#btn-form").attr("method","get");
                    $("#btn-form").attr("action",fullURL);
                    $("#btn-form").submit();
                    // window.location.replace(url);
                }
            }else{
                $("#modal-overlay").css({"display":"none"});
            }
            })
            
        })
        $(".close").on("click",function(){
            $("#modal-overlay").css({"display":"none"});
        })
        function chkbool(string){
            if(string === "true"){
                return true;
            }else if(string === "false"){
                return false;
            }
        }
        function chkbeh(string){
            if(string === "수정"){
                return "update";
            }else if(string ==="삭제"){
                return "delete";
            }
        }
    </script>
</body>
</html>