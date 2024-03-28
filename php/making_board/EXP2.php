<?php 
    $getData = file_get_contents("php://input");
    $formData = json_decode($getData);
    print_r($formData);
    
    //현재 비밀번호가 맞는지 확인
    global $connect;
    $sql = "SELECT user_pw FROM member WHERE user_id =:userID";
    try{
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':userID',$formData->user_id);
        $stmt->execute();
        $userPW = $stmt->fetch(PDO::FETCH_COLUMN);
    }catch(PDOException $ex){

    }
    if(!password_verify($formData->currentPW,$userPW)):
        $resultArray = [
            'serverResponse'=>false,'deniedReason'=>'inaccurate pw','msg'=>'현재 비밀번호를 확인해주세요'
        ];
        echo json_encode( $resultArray);
        return;
    endif;
    
    //입력한 비밀번호 두 번 정확히 입력했는지 확인
    if(!($formData->nextPW===$formData->checkPW)):
        $resultArray = [
            'serverResponse'=>false,'deniedReason'=>'inaccurate check pw','msg'=>'입력한 두 비밀번호가 일치하지 않습니다.'
        ];
        echo json_encode( $resultArray);
        return;
    endif;
    //바꿀 비밀번호 형식이 맞는지 확인

    //비밀번호 바꾸기
    $sql = "UPDATE member SET user_pw=:userPW WHERE user_id=:userID";
    try{
        $nextPW = password_hash($formData->nextPW,PASSWORD_DEFAULT);
        $stmt = $connect->prepare($sql);
        $stmt->bindParam('userPW',$nextPW);
        $stmt->bindParam('userID',$formData->user_id);
        $stmt->execute();
        $resultCount = $stmt->rowCount();
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
    print_r($resultCount);
?>