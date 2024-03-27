
<?php

    require('UserBuilder.php');

    

    //필수인 것들 비었을 때의 메시지
    
    
    //비어있는지와 제대로 입력되었는지 유효성검사(id, 이름, pw, email 은 필수)(gender와 birth는 선택)
    //더 제대로 된 검증이 필요한듯?
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $continueBuild = false;
        
        $data = file_get_contents('php://input');
        $jsondata = json_decode($data);

        //User class안에 msg [] 를 만들어서 해당 오류를 다 집어넣고 리턴을 시키면 어떨까?
        try{
            $newUser = User::builder()
            ->valID($jsondata->id)
            ->valName($jsondata->name)
            ->valPassword(password_hash($jsondata->password,PASSWORD_DEFAULT))
            ->valGender($jsondata->gender)
            ->valEmail($jsondata->email)
            ->valBirth($jsondata->birth)
            ->build();
            $continueBuild = true;
        }catch(InvalidArgumentException $ex){
            $resultArray=[
                'serverResponse'=>false,'deninedReason'=>$ex->getMessage()
            ];
            echo jsonMaker($resultArray);
        }        
        
        // db랑 연결 시작(insert)
        if($continueBuild){
            global $connect;
            
            $connect ->beginTransaction();
            try{
                $sql = 
                    "INSERT INTO member
                        set user_id = :id,
                            user_pw = :password,
                            name = :name,
                            gender=:gender,
                            birth = :birth,
                            email = :email";
                $params = $newUser->getArrayProp();
                
                $stmt = $connect->prepare($sql);
                //$value를 참조로 전달해서 PDO::PARAM_STR 에 맞지 않으면 자동으로 변환이 가능하게
                foreach ($params as $param=>&$value){
                    if($param==':gender'){
                        $stmt->bindParam($param,$value,PDO::PARAM_STR);
                    }else{
                        $stmt->bindParam($param,$value);
                    }
                }
                
                $result = $stmt->execute();
                $connect->commit();
                $resultArray = [
                    'serverResponse'=>true
                ];
                
            }catch(PDOException $ex){
                $connect ->rollBack();
                $resultArray=[
                    'serverResponse'=>false,'deninedReason'=>$ex->getMessage()
                ];   
            }
            echo jsonMaker($resultArray)  ;
        }
            
                
    }
?>