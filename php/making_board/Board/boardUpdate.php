<?php 
    global $connect;
    
    $resultArray = [];
    
    parse_str(file_get_contents('php://input'),$result);
    
    $id = $boardID;
    $title = $result["title"];
    $text = $result["text"];
    
    $sql = "UPDATE board
                 SET
                    title = '$title',
                    text = '$text'
                WHERE id = '$id'                
            ";
    try{
        $stmt = $connect -> prepare($sql);
        $stmt ->execute();
        $resultArray = array(
            'serverResponse'=>true
        );
    }catch(PDOException $ex){
        $resultArray = [
            'serverResponse'=>false,'deniedReason'=>$ex->getMessage()
        ];
    }
    header('Content-Type: application/json');
    echo json_encode($resultArray,JSON_PRETTY_PRINT,JSON_UNESCAPED_UNICODE);
?>