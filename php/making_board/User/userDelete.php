<?php 
    try{
        $data = file_get_contents("php://input");
        $jsonData = json_decode($data);
        $user_id = $jsonData->user_id;
        if(isset($jsonData->admin)):
            $adminAction = true;
        else:
            $adminAction = false;
        endif;
        
        
        

    }catch(Exception $ex){
        $resultArray = ['serverResponse'=>false,'deninedReason'=>$ex->getMessage()];
        echo jsonMaker($resultArray);
        return;
    }

    global $connect;
    try{
        $sql = "SELECT user_pk FROM member WHERE user_id =:userID";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':userID',$user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }catch(PDOException $ex){
        $resultArray = ['serverResponse'=>false,'deninedReason'=>$ex->getMessage()];
        echo jsonMaker($resultArray);
        return;
    }
    
    try{
        $sql = "DELETE FROM member WHERE user_pk =:user_pk";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':user_pk',$result["user_pk"]);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
    }catch(PDOException $ex){
        $resultArray = ['serverResponse'=>false,'deninedReason'=>$ex->getMessage()];
        echo jsonMaker($resultArray);
        return;
    }
    if($rowCount):
        $resultArray = ['serverResponse'=>true];
    else:
        $resultArray = ['serverResponse'=>false,'deninedReason'=>'not exist'];
    endif;
    if(!$adminAction):
        // session_start();
        $_SESSION = array();
        if(ini_get("session.use_cookies")){//ini 파일에서 cookies 사용하고 있는지 묻는 것
            $params = session_get_cookie_params();//현재 사용하고 있는 쿠키 정보 불러옴
            setcookie(session_name(),'',time()-42000,
                $params["path"], $params["domain"],
                $params["secure"],$params["httponly"]);
        }
        session_destroy();
        echo jsonMaker($resultArray);
    else:
        echo jsonMaker($resultArray);
    endif;
    return;
?>