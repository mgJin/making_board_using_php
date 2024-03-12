<?php 
    require(__DIR__.'/Settings/config.php');

    $data= file_get_contents("php://input");
    $jsonData = json_decode($data);
    $roleName = $jsonData->role_name;

    // $sql = "SELECT id FROM roles WHERE name=:name";
    // $stmt = $connect->prepare($sql);
    // $stmt->bindParam(':name',$roleName);
    // $stmt->execute();
    // $roleID = $stmt->fetch(PDO::FETCH_COLUMN);
    
    try{
        $sql = "SELECT p.name as permission FROM permission_role pr JOIN permissions p ON pr.permission_id = p.id  WHERE pr.role_id=(SELECT id FROM roles WHERE name=:name) ";
        $stmt=$connect->prepare($sql);
        $stmt->bindParam(':name',$roleName);
        $stmt->execute();
        $permissions = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
    }catch(PDOException $ex){
        echo json_encode([
            "serverResponse"=>false,"deniedReason"=>$ex->getMessage()
        ]);
        return;
    }
    echo json_encode($permissions);
?>