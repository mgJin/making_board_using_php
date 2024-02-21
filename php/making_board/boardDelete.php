<?php 
    global $connect;
    
    $board_id = $var;
    
    $sql = "DELETE FROM board WHERE id = '$board_id'";
    try{
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
    }catch(PDOException $ex){
        
        $resultArray = array(
            'serverResponse' =>false,
            'exMsg' => $ex->getMessage()
        );
        echo json_encode($resultArray,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    }
    $resultArray= array(
        'serverResponse'=>true
    );
    echo json_encode($resultArray,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
?>