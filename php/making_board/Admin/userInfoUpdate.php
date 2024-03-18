<?php

$data = file_get_contents("php://input");
$jsonData = json_decode($data);
// echo json_encode($jsonData->role_name);
global $connect;
//role_name으로 roleid찾기
$sql = "SELECT id FROM roles WHERE name=:name LIMIT 1";
try {
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':name', $jsonData->roleName);
    $stmt->execute();
    $roleID = $stmt->fetch(PDO::FETCH_COLUMN);
} catch (PDOException $ex) {
    $resultArray = [
        "serverResponse" => false,
        "deniedReason" => $ex->getMessage()
    ];
    echo json_encode($resultArray);
    return;
}

$sql = "UPDATE member
                SET role_id=:roleID
                WHERE user_pk=:userPK";
try {
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':roleID', $roleID);
    $stmt->bindParam(':userPK', $user_pk);
    $stmt->execute();
    $resultArray = [
        "serverResponse"=>true
    ];
} catch (PDOException $ex) {
    $resultArray = [
        "serverResponse" => false,
        "deniedReason" => $ex->getMessage()
    ];
 
}
echo json_encode($resultArray);


