<?php 
    // file_get_contents("php://input");
//insert 페이지
//기존에 있던 role인지 확인 후 insert
//admin 권한이 있는지는 admin페이지 자체에 있으니깐 권한 확인을 해야할까?
require(__DIR__.'/Settings/config.php');
use function PHPSTORM_META\type;
    // role은 무조건 선택해야함.
    // permissions 는 선택 안해도 됨 => 선택했을때에만 explode가 작동하게
    // if(!isset($_POST["role"])):
    //     $resultArray = [
    //         "serverResponse"=>false,"deninedReason"=>"not choice role"
    //     ];
    //     echo json_encode($resultArray);
    //     return;
    // else:
    //     $role = $_POST["role"];
    // endif;
    // if(isset($_POST["permissionsArray"])):
    //     $permissionsString = $_POST["permissionsArray"];
    //     $permissionsArray = explode(",",$permissionsString);
    // else:
    //     $permissionsArray = [];
    // endif;
            
    $role = 'dsadsfdddddf';
            
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
        $lastInsertID = $connect->lastInsertId();
    }catch(PDOException $ex){
        $resultArray = [
            "serverResponse"=>false,"deninedReason"=>$ex->getMessage()
        ];
    }
    $permissionsArray = ['create-user','update-board','delete-board'];
    // print_r($pnames);
    //permission들의 id들을 가져오는 것 구현. permissions_role table에 role과 permissions 추가
    //permissions에 뭐가 들어있어야 해당 구문들 실행
    if(count($permissionsArray)>0):
        echo $lastInsertID;
        $pnames = implode(",",array_fill(0,count($permissionsArray),"?"));
        $sql = "SELECT id FROM permissions WHERE name in ($pnames) ORDER BY id";
        try{
            $stmt = $connect->prepare($sql);
            foreach($permissionsArray as $index => $value){
                $stmt->bindValue($index+1,$value);
            }
            $stmt->execute();
            $permissionIDs = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }catch(PDOException $ex){
            $resultArray = [
                "serverResponse"=>false,"deninedReason"=>$ex->getMessage()
            ];
            echo $ex->getMessage();
        }
        print_r($permissionIDs);
        $questionmarks = implode(",",array_fill(0,count($permissionIDs),"(?,?)"));
        $sql = "INSERT INTO permission_role (role_id,permission_id) VALUES ";
        $sql.=$questionmarks;
        try{
            $stmt = $connect->prepare($sql);
            for($i=0;$i<count($permissionIDs);$i++){
                $stmt->bindValue(2*$i+1,$lastInsertID);
                $stmt->bindValue(2*$i+2,$permissionIDs[$i]);
            }
            $stmt->execute();
            echo $stmt->rowCount();
        }catch(PDOException $ex){
            $resultArray = [
                "serverResponse"=>false,"deninedReason"=>$ex->getMessage()
            ];
            echo $ex->getMessage();
        }
                    

    endif;
    //permissions_role table에 추가
    // echo json_encode($resultArray);
    
    //on 인것들의 array를 만든 다음 db에 있던 role-permission에 해당 하는 것들을 지우고
    //role-permission에 해당 하는 role id에 permission들을 추가
    //update와 insert를 구분하기 위해서 이미 있던 role인지 구분하는게 필요
?>