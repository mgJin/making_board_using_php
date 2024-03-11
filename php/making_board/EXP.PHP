<?php 
    // file_get_contents("php://input");
//insert 페이지
//기존에 있던 role인지 확인 후 insert
//admin 권한이 있는지는 admin페이지 자체에 있으니깐 권한 확인을 해야할까?
require(__DIR__.'/Settings/config.php');
use function PHPSTORM_META\type;
    //role은 무조건 선택해야함.
    //permissions 는 선택 안해도 됨 => 선택했을때에만 explode가 작동하게
    // if(!isset($_POST["role"])):
    //     $resultArray = [
    //         "serverResponse"=>false,"deninedReason"=>"not choice role"
    //     ];
    //     echo json_encode($resultArray);
    //     return;
    // else:
    //     $role = $_POST["role"];
    // endif;
        $role = 'Admin';
    if(isset($_POST["permissionsArray"])):
        $permissionsString = $_POST["permissionsArray"];
        $permissionsArray = explode(",",$permissionsString);
    else:
        $permissionsArray = [];
    endif;
    
    
    //처음에는 기존에 있던 것인지 검증

    $sql = "SELECT name FROM roles WHERE name =:name";
    try{
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':name',$role);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $rowResult = $stmt->rowCount();
    }catch(PDOException $ex){
        $resultArray = [
            "serverResponse"=>false,"deniedReason"=>$ex->getMessage()
        ];
    }
    if($rowResult){
        $resultArray = [
            "serverResponse"=>false,"deninedReason"=>"This role already exists"
        ];
        echo json_encode($resultArray);
        return;
    }
    //description column은 null가능, 추가로 description을 건드릴 수 있는 옵션을 만들자
    $sql = "INSERT INTO roles
                set name = :name";
    try{
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':name',$role);
        $stmt->execute();
        $rowResult = $stmt->rowCount();
    }catch(PDOException $ex){
        $resultArray = [
            "serverResponse"=>false,"deninedReason"=>$ex->getMessage()
        ];
    }
    //permission들의 id들을 가져오는 것 구현. permissions_role table에 role과 permissions 추가
    $sql = "";
    // echo json_encode($resultArray);
    
    //on 인것들의 array를 만든 다음 db에 있던 role-permission에 해당 하는 것들을 지우고
    //role-permission에 해당 하는 role id에 permission들을 추가
    //update와 insert를 구분하기 위해서 이미 있던 role인지 구분하는게 필요
?>