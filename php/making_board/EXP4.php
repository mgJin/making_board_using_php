<?php 
    require(__DIR__.'/Settings/config.php');
    $data =file_get_contents("php://input");
    $formData = json_decode($data);     
    //role을 선택하지 않았다면 return
    if(!$formData->role):
        $resultArray = [
                "serverResponse"=>false,"deniedReason"=>"not choice role"
        ];
        echo json_encode($resultArray);
        return;
    else:
        $role = $formData->role;
    endif;
    //이미 있는 role인지 확인
    //name 은 unique니깐 limit 1
    $sql = "SELECT id FROM roles WHERE name=:name LIMIT 1";
    try{
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':name',$role);
        $stmt->execute();
        $roleID = $stmt->fetch(PDO::FETCH_COLUMN);
        $rowCount = $stmt->rowCount();
    }catch(PDOException $ex){
        $resultArray = [
            "serverResponse"=>false,"deniedReason"=>$ex->getMessage()
        ];
    }
    if($rowCount==0):
        $resultArray=[
            "serverResponse"=>false,"deniedReason"=>"not exist role"
        ];
        echo json_encode($resultArray);
        return;
    endif;

    $sql = "UPDATE permission_role 
                set permission
                WHERE role_id = :roleID";



?>