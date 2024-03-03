<?php
    require('UserBuilder.php');
    //fetch 로 받은 데이터 
    $formData = file_get_contents('php://input');
    $getData = json_decode($formData);
    
    //db 연결해서 해당 아이디의 pk 받기
    global $connect;
    $user_id = $_SESSION["user"]["user_id"];
    try{
        $sql = "SELECT user_pk FROM member WHERE user_id =:userID";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':userID',$user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $ex){
        $resultArray = ['serverResponse'=>false,'deninedReason'=>$ex->getMessage()];
        
    }
    //해당 유저의 pk로 user update 진행
    try{
        $user = USER::builder()
        ->valID($getData->id)
        ->valName($getData->name)
        ->valGender($getData->gender)
        ->valBirth($getData->birth)
        ->valEmail($getData->email)
        ->build();
    }catch(InvalidArgumentException $ex){
        $resultArray=['serverResponse'=>false,'deniedReason'=>$ex->getMessage()];
        echo jsonMaker($resultArray);
        return;
    }

    $userArr = $user->getArrayProp();
    $sql = "UPDATE member
                set user_id=:id,
                    name=:name,
                    gender=:gender,
                    birth=:birth,
                    email=:email
                Where user_pk =:user_pk";
    try{
        
        $stmt = $connect->prepare($sql);
        foreach($userArr as $props=>&$value){
            if($props==':password'):
                continue;
            endif;
            if($props==':gender'):
                $stmt->bindParam($props,$value,PDO::PARAM_STR);
                continue;
            endif;
            $stmt->bindParam($props,$value);
        }
        $stmt->bindParam(':user_pk',$result["user_pk"]);
        $result = $stmt->execute();
        if($result):
            $rowCount = $stmt->rowCount();
            if($rowCount):
                $resultArray = ['serverResponse'=>true];
            else:
                $resultArray = ['serverResponse'=>false,'deninedReason'=>'0행 업데이트'];
            endif;
        endif;
            
        
    }catch(PDOException $ex){
        $resultArray = ['serverResponse'=>false,'deninedReason'=>$ex->getMessage()];
        
    }catch(error $ex){
        $resultArray = ['serverResponse'=>false,'deninedReason'=>$ex->getMessage()];
        
    }
    
    echo jsonMaker($resultArray);
?>