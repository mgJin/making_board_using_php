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
        require_once('dbconnect_root.php');
        $board_id = $_GET["id"];
        $sql = "SELECT title,text,writer FROM board WHERE id = $board_id";
        $stmt = $connect->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);    
    ?>
   
    <div>
        <h2>제목 : <?php echo $result["title"] ?></h2>
        <span>작성자 : <?php echo $result["writer"]?></span>
        <br>
        <span><?php echo $result["text"]?></span>
    </div>
    
        <button class="crdbtn" id="updbtn" value=<?php echo $board_id?>>수정</button>
        <button class="crdbtn" id="delbtn" value=<?php echo $board_id?>>삭제</button>
    
    <div id="modal-overlay">
        <div id="modal-window">
            <div class="title">
                <h3>확인창</h3>
            </div>
            <div class="close">x</div>
            <div class="modal-content">
                <p id="chkp"></p>
                <form id="btn-form">
                    <button class="chkbtn" value=true>확인</button>
                    <button class="chkbtn" value=false>취소</button>
                </form>
            </div>
        </div>
    </div>
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
                if(action==="delete"){
                    let fullURL = action + "_board.php";
                    $.ajax({
                        type: "POST",
                        url : fullURL,
                        data : {id:e.data.id},
                        success : function(result){
                            let url = "http://localhost:3000/view_all_board.php";
                            if(result==="1"){
                                alert(e.data.action+'되었습니다');
                            }else if(result==="0"){
                                alert('없는 게시물입니다');
                            }else{
                                alert(e.data.action+'실패');
                            } 
                            window.location.replace(url);
                        },
                        error : function(request,status,error){
                            console.log(error);
                        }
                    });
                }else if(action==="update"){
                    let url = "http://localhost:3000/update_form.php";
                    var id_hidden = $("<input>")
                                        .attr("type","hidden")
                                        .attr("name","id")
                                        .val(e.data.id);
                    $("#btn-form").append($(id_hidden));
                    $("#btn-form").attr("method","post");
                    $("#btn-form").attr("action",url);
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