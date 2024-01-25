<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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

        // if($_SERVER["REQUEST_METHOD"]=="POST"){
        //     if(!$_POST["title"]){
        //         $titleMsg = "제목을 입력해주세요";
        //         $dbconnect = false;
        //     }else{
        //         $title = $_POST["title"];
        //     }
        //     $text = $_POST["text"];
        // }
    ?> 
    <form class="upd-form">
        제목 : <input type = "text" name = "title" value=<?php echo $title?>>
        <?php echo $titleMsg;?>
        내용 : <input type = "text" name = "text" value=<?php echo $text?>>
        <input class="crdbtn" type = "button" value="글쓰기">
    </form>
</body>
</html>