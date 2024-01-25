<?php 
    require_once ('dbconnect_root.php');
    $id = $_POST["id"];
    $title = $_POST["title"];
    $text = $_POST["text"];
    
    $sql = "UPDATE board
                 SET
                    title = '$title',
                    text = '$text'
                WHERE id = '$id'                
            ";
    try{
        $stmt = $connect -> prepare($sql);
        $stmt ->execute();
        $count = $stmt->rowCount();
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
    echo $count;
?>