<?php use app\User\User; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>회원가입</title>
    </head>
    <body>
        <!--유저 생성 권한만 있는 슈퍼유저가 필요할 듯? -->
    <!--유저 생성 시 id가 unique 인 동시에 not null 이어야할듯-->
    <?php
        //필수인 것들 비었을 때의 메시지
        $NameMsg = $IDMsg = $PWMsg = $EmailMsg = "" ;
        $dbconnect;
        //비어있는지와 제대로 입력되었는지 유효성검사(id, 이름, pw, email 은 필수)(gender와 birth는 선택)
        //더 제대로 된 검증이 필요한듯?
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){

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
            try{
                $newUser = User::builder()
                ->valID($_POST["id"])
                ->valName($_POST["name"])
                ->valPassword($_POST["password"])
                ->valGender($_POST["gender"])
                ->valEmail($_POST["email"])
                ->valBirth($_POST["birth"])
                ->build();
            }catch(InvalidArgumentException $ex){
                echo $ex->getMessage();
            }
            
            //입력한 값들이 문제가 없다면 dbconnect = true;
            //db랑 연결 시작(insert)
            if($newUser->result){
                $servername = "localhost";
                $dbname = "phpboard";
                $dbuser = "root";
                $dbpassword = "9094";

                try{
                    $signUpConnect = new PDO("mysql:host=$servername;dbname=$dbname",$dbuser,$dbpassword);
                    $signUpConnect -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                    $signUpConnect ->setAttribute(PDO::ATTR_AUTOCOMMIT,false);
                    echo "서버 연결 성공"."<br>";   
                }catch(PDOException $exc){
                    echo "서버 연결 실패 이유 :".$exc->getMessage();
                }
                //member테이블에 추가, db에 유저추가(권한은 board는 all, member는 update랑 delete)
                //CREATE USER, GRANT 는 implicit commit 이라 transaction 안에 가두면 에러남
               
                $signUpConnect ->beginTransaction();
                try{
                    if(!empty($newUser->getBirth())){
                        //sql 구문을 prepare로 넣고 뒤에 bindparam을 통해서 getID등을 넣자
                    $signUpConnect ->exec(
                        "INSERT INTO member
                            set user_id = :id,
                                user_pw = '$password',
                                name = '$name',
                                gender = '$gender',
                                birth = '$birth',
                                email = '$email'");
                    }else{
                    $signUpConnect ->exec(
                        "INSERT INTO member
                            set user_id = '$id',
                                user_pw = '$password',
                                name = '$name',
                                gender = '$gender',
                                birth = NULL,
                                email = '$email'");
                    }
                    $result = $signUpConnect ->commit();
                    //권한 부여 =>permissions table 로 대체
                    // $signUpConnect ->exec("CREATE USER '$id'@'localhost' IDENTIFIED BY '$password'");
                    // $signUpConnect ->exec("GRANT ALL PRIVILEGES ON phpboard.board To '$id'@'localhost'");
                    // $signUpConnect ->exec("GRANT UPDATE,DELETE ON phpboard.member TO '$id'@'localhost'");
                    if($result){
                        echo "<script>alert('생성되었습니다')</script>";
                        header("http://localhost:3000/boards");
                    }
                }catch(PDOException $ex){
                    $signUpConnect ->rollBack();
                    echo "유저생성실패 ". $ex->getMessage();
                }
              
            }
                
                    
        }
    ?>
    <?php 
        var_dump($_REQUEST)."<br>";
    ?>
    <!--gender 의 datatype :  enum('male','female') -->
    <!--submit누르고 확인버튼 나오는 거랑, 회원가입이 성공하면 /boards 로 이동하게 -->
    <form action = "http://localhost:3000/user" method = "post">
        ID : <input type = "text" name="id">
        <?php echo $IDMsg;?>
        이름 : <input type = "text" name = "name">
        <?php echo $NameMsg;?>
        PW : <input type = "password" name= "password">
        <?php echo $PWMsg;?>
        Gender : <input type= "radio" name= "gender" value="1">남자
                 <input type= "radio" name= "gender" value="2">여자
        birth : <input type = "date" name= "birth">
        <br>
        email : <input type = "text" name="email">
        <?php echo $EmailMsg;?>
        <input type="submit">
    </form>
    
    
</body>
</html>