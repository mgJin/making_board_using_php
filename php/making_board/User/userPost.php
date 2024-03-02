
<?php

    require('UserBuilder.php');

    

    //필수인 것들 비었을 때의 메시지
    
    
    //비어있는지와 제대로 입력되었는지 유효성검사(id, 이름, pw, email 은 필수)(gender와 birth는 선택)
    //더 제대로 된 검증이 필요한듯?
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $continueBuild = false;
        
        
        //validation
        //일단 User를 만들때를 생각하고 해당 validation통과 못하면 false 반환하는 식으로?
        //이것도 클래스로 만들어서 통과못하는 사유랑 msg를 같이 담아서 보낼 수 있도록할까?
        // if(empty($_POST["id"])){
        //     $IDMsg = "ID를 입력해주세요";
        //     $dbconnect = false;
        // }else{
        //     $id = $_POST["id"];
        // }

        // if(empty($_POST["name"])){
        //     $NameMsg = "이름을 입력해주세요";
        //     $dbconnect = false;
        // }else{
        //     $name = $_POST["name"];
        // }

        // if(empty($_POST["password"])){
        //     $PWMsg = "패스워드를 입력해주세요";
        //     $dbconnect = false;
        // }else{
        //     $password = $_POST["password"];
        // }
        
        // if(empty($_POST["email"])){
        //     $EmailMsg = "이메일을 입력해주세요";
        //     $dbconnect = false;
        // }else{
        //     $email = $_POST["email"];
        //     var_dump($email);
        //     if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        //         $EmailMsg = "이메일을 정확하게 입력해 주세요";
        //     }
        // }
        
        // if(empty($_POST["gender"])){
        //     $gender = null;
        // }else{
        //     $gender = $_POST["gender"];
        // };
        // if(empty($_POST["birth"])||($_POST=="")){
        //     $birth = NULL;
        //     echo "생일이 비어있음";
        //     echo "<br>"."생일의 값은 :";
        //     var_dump($birth);
        // }else{
        //     $birth = $_POST["birth"];
        // };
        // header('Content-Type: application/json');
        $data = file_get_contents('php://input');
        $jsondata = json_decode($data);

        //User class안에 msg [] 를 만들어서 해당 오류를 다 집어넣고 리턴을 시키면 어떨까?
        try{
            $newUser = User::builder()
            ->valID($jsondata->id)
            ->valName($jsondata->name)
            ->valPassword($jsondata->password)
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

        //db랑 연결 시작(insert)
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
                echo jsonMaker($resultArray);
            }
            echo jsonMaker($resultArray)  ;
        }
            
                
    }
?>