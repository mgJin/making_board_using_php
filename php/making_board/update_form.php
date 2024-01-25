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
    <?php include '../making_board/front/html/index.html'; ?>
    <?php
        $titleMsg = "";
        $board_id = $_POST["id"];
        // 입력검증
        require_once('dbconnect_root.php');
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
        제목 : <input type = "text" name = "title" value=<?php echo $title?>>
        <?php echo $titleMsg;?>
        내용 : <input type = "text" name = "text" value=<?php echo $text?>>
        <input class="crdbtn" type = "button" value="수정">
    </form>
    
    <script>
        
    </script>
</body>
</html>