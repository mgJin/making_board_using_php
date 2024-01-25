<?php 
    require_once('dbconnect_root.php');
    
    $board_id = $_POST["id"];
    
    $sql = "DELETE FROM board WHERE id = '$board_id'";
    try{
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
    echo $count;
?>