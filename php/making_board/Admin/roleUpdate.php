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
    //delete를 하고 insert를 해야겠다.
    //delete
    $sql = "DELETE FROM permission_role WHERE role_id=:roleID";
    try{
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':roleID',$roleID);
        $stmt->execute();
    }catch(PDOException $ex){
        $resultArray=[
            "serverResponse"=>false,"deniedReason"=>$ex->getMessage()
        ];
        echo json_encode($resultArray);
    }
    //insert
    //permission들 id찾기
    if(!$formData->permissionsValues):
        echo json_encode([
            "serverResponse"=>true
        ]);
        return;
    endif;
    $permissions = $formData->permissionsValues;
    $placeholder = implode(",",array_fill(0,count($permissions),"?"));
    $sql = "SELECT id FROM permissions WHERE name in ($placeholder) ORDER BY id";
    try{
        $stmt = $connect->prepare($sql);
        foreach($permissions as $index=>$permission):
            $stmt->bindValue($index+1,$permission);
        endforeach;
        $stmt->execute();
        $permissionIDs = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }catch(PDOException $ex){
        $resultArray=[
                    "serverResponse"=>false,"deniedReason"=>$ex->getMessage()
                ];
        echo json_encode($resultArray);
        return;
    }
    $twoQuestionMarks = implode(",",array_fill(0,count($permissions),"(?,?)"));
    $sql = "INSERT INTO permission_role (role_id,permission_id) VALUES $twoQuestionMarks";
    try{
        $stmt = $connect->prepare($sql);
        foreach($permissionIDs as $index=>$permissionID):
            $stmt->bindValue(2*$index+1,$roleID);
            $stmt->bindValue(2*$index+2,$permissionID);
        endforeach;
        $stmt->execute();
    }catch(PDOException $ex){
        $resultArray=[
            "serverResponse"=>false,"deniedReason"=>$ex->getMessage()
        ];
        echo json_encode($resultArray);
        return;    
    }
    echo json_encode([
        "serverResponse"=>true
    ]);

?>