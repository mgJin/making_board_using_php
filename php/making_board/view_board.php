<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 보기</title>
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
    <?php 
        if(array_key_exists("update",$_POST)){
            $beh = "update";
            echo chkbutton($beh,$_POST["$beh"]);
        }else if(array_key_exists("delete",$_POST)){
            $beh = "delete";
            echo chkbutton($beh,$_POST["$beh"]);
        }
        function chkbutton(string $beh,string $hangul){
    
            $ev = "var chk= confirm('$hangul 하시겠습니까?');
                   if(chk){
                    var php = '$beh'+'_board.php';
                    location = php;}"
                    ;
            return "<script>$ev</script>";
        }
    ?>
    <div>
        <h2>제목 : <?php echo $result["title"] ?></h2>
        <span>작성자 : <?php echo $result["writer"]?></span>
        <br>
        <span><?php echo $result["text"]?></span>
    </div>
    <form method="post">
        <input type="submit" name = "update" value = "수정">
        <input type="submit" name = "delete" value = "삭제">
    </form>
    
</body>
</html>