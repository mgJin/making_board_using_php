<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
</head>
<body>
    <!--유저 생성 권한만 있는 슈퍼유저가 필요할 듯? -->
    <?php
        //필수인 것들 비었을 때의 메시지
        $NameMsg = $IDMsg = $PWMsg = $EmailMsg = "" ;
        $dbconnect = true;
        //비어있는지와 제대로 입력되었는지 유효성검사(id, 이름, pw, email 은 필수)(gender와 birth는 선택)
        //더 제대로 된 검증이 필요한듯?
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(empty($_POST["id"])){
                $IDMsg = "ID를 입력해주세요";
                $dbconnect = false;
            }else{
                $id = $_POST["id"];
            }

            if(empty($_POST["name"])){
                $NameMsg = "이름을 입력해주세요";
                $dbconnect = false;
            }else{
                $name = $_POST["name"];
            }

            if(empty($_POST["password"])){
                $PWMsg = "패스워드를 입력해주세요";
                $dbconnect = false;
            }else{
                $password = $_POST["password"];
            }
            
            if(empty($_POST["email"])){
                $EmailMsg = "이메일을 입력해주세요";
                $dbconnect = false;
            }else{
                $email = $_POST["email"];
                var_dump($email);
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $EmailMsg = "이메일을 정확하게 입력해 주세요";
                }
            }
            
            if(empty($_POST["gender"])){
                $gender = null;
            }else{
                $gender = $_POST["gender"];
            };
            if(empty($_POST["birth"])||($_POST=="")){
                $birth = NULL;
                echo "생일이 비어있음";
                echo "<br>"."생일의 값은 :";
                var_dump($birth);
            }else{
                $birth = $_POST["birth"];
            };
            
            //입력한 값들이 문제가 없다면 dbconnect = true;
            //db랑 연결 시작(insert)
            if($dbconnect = true){
                $servername = "localhost";
                $dbname = "phpboard";
                $user = "root";
                $dbpassword = "9094";

                try{
                    $connect = new PDO("mysql:host=$servername;dbname=$dbname",$user,$dbpassword);
                    $connect -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                    $connect ->setAttribute(PDO::ATTR_AUTOCOMMIT,false);
                    echo "서버 연결 성공"."<br>";   
                }catch(PDOException $exc){
                    echo "서버 연결 실패 이유 :".$exc->getMessage();
                }
                //member테이블에 추가, db에 유저추가(권한은 board는 all, member는 update랑 delete)
                //CREATE USER, GRANT 는 implicit commit 이라 transaction 안에 가두면 에러남
               
                $connect ->beginTransaction();
                try{
                    if(!empty($birth)){
                    $connect ->exec(
                        "INSERT INTO member
                            set user_id = '$id',
                                user_pw = '$password',
                                name = '$name',
                                gender = '$gender',
                                birth = '$birth',
                                email = '$email'");
                    }else{
                    $connect ->exec(
                        "INSERT INTO member
                            set user_id = '$id',
                                user_pw = '$password',
                                name = '$name',
                                gender = '$gender',
                                birth = NULL,
                                email = '$email'");
                    }
                    $connect ->commit();
                    $connect ->exec("CREATE USER '$id'@'localhost' IDENTIFIED BY '$password'");
                    $connect ->exec("GRANT ALL PRIVILEGES ON phpboard.board To '$id'@'localhost'");
                    $connect ->exec("GRANT UPDATE,DELETE ON phpboard.member TO '$id'@'localhost'");
                    echo "유저생성성공";
                }catch(PDOException $ex){
                    $connect ->rollBack();
                    echo "유저생성실패 ". $ex->getMessage();
                }
              
            }
                
                    
        }
    ?>
    <?php 
        var_dump($_REQUEST)."<br>";
    ?>
    <!--gender 의 datatype :  enum('male','female') -->
    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">
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