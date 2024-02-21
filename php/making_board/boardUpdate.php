<?php 
    global $connect;
    parse_str(file_get_contents('php://input'),$result);
    $id = $result['id'];
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
        $count = $stmt->rowCount();
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
    $resultArray = array(
        'serverResponse'=>true
    );
    echo json_encode($resultArray,JSON_PRETTY_PRINT,JSON_UNESCAPED_UNICODE);
?>