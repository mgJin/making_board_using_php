<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 보기</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
        #modal-overlay{
            width:100%;
            height:100%;
            position:absolute;
            left:0;
            top:0;
            display:none;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            background:rgba(255,255,255,0.25);
            backdrop-filter:blur(1.5px)
        }
        #modal-window{
            top:50%;
            left:50%;
            width:150px;
            height:100px;
            padding:20px;
            border:1px solid #eee;
            background-color:rgba(230,230,230,0.7);
            text-align:center
        }
        #chkp{
            font-size:12px;
        }
        .title{
            padding-left: 10px;
            display: inline;
            text-shadow: 1px 1px 2px gray;
            color: white;
        }
        .title h3{
            display:inline;
        }
        .close{
            display:inline;
            float: right;
            padding-right: 1px;
            cursor: pointer;
            text-shadow: 1px 1px 2px gray;
            color: white;
        }
        .modal-content{
            margin-top: 20px;
            padding: 0px 10px;
        }
    </style>
    
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
            let bool = chkbool(e.target.value);
            e.preventDefault();
            if(bool){
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