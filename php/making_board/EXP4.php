<?php 
    require(__DIR__.'/Settings/config.php');
    $data = file_get_contents("php://input");
    $jsonData = json_decode($data);
    //선택했는지 확인
    if(!$jsonData->checkedRole):
        echo json_encode([
            "serverResponse"=>false,"deniedReason"=>"not choice role"
        ]);
        return;
    else:
        $roleName = $jsonData->checkedRole;
    endif;
    $sql = "DELETE FROM roles WHERE id=(SELECT id FROM (SELECT id FROM roles WHERE name=:name) AS T);";
    try{
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':name',$roleName);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
    }catch(PDOException $ex){
        echo json_encode([
            "serverResponse"=>false,"deniedReason"=>$ex->getMessage()
        ]);
        return;
    }
    if(!$rowCount):
        echo json_encode([
            "severResponse"=>false,"deniedReason"=>"not exist role"
        ]);
    else:
        echo json_encode([
            "serverResponse"=>true
        ]);
    endif;
?>