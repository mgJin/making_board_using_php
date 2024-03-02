<?php 
    global $connect;
    
    $board_id = $boardID;
    
    $sql = "DELETE FROM board WHERE id = '$board_id'";
    try{
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
        $resultArray= array(
            'serverResponse'=>true
        );
    }catch(PDOException $ex){
        $resultArray = [
            'serverResponse'=>false,'deniedReason'=>$ex->getMessage()
        ];
    }
    header('Content-Type: application/json');

    echo json_encode($resultArray,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
?>