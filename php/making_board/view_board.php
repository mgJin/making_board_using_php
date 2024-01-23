<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 보기</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>
<body>
    <!--권한 제한된 유저를 만들어서 그놈이 보는걸로 -->
    <!--삭제 버튼 누를 때 권한 확인 필요-->
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
    <form id="btn_form">
        <button class="crdbtn" id="updbtn" value=<?php $board_id?>>수정</button>
        <button class="crdbtn" id="delbtn" value=<?php $board_id?>>삭제</button>
    </form>
    <script>
        $(".crdbtn").on("click",function(event){
            const beh = event.target.innerText;
            let chk = confirm(beh+"하시겠습니까?",function(result){
                if(result){
                    $("#btn_form").attr("action","delete_board.php");
                    $("#btn_form").submit();
                }else{
                    window.location.replace("http://www.naver.com");
                }
            });
           
           
        })
    </script>
</body>
</html>