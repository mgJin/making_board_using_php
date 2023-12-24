<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //DB연결
        $servername = "localhost";
        $dbname = "phpboard";
        $user = "test1";
        $password = "1111";

        try{
            $connect = new PDO("mysql:host=$servername;dbname=$dbname",$user,$password);
            $connect -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            echo "서버 연결 성공";
        }catch(PDOException $exc){
            echo "서버 연결 실패 이유 :".$exc->getMessage();
        }
        //쿼리문
       $sql = "INSERT INTO member( * FROM member";
        //구문을 넣어서 db에 보내기 할 것
    //    $stmt = $connect->query($sql);
    //    $result = $stmt->fetch(PDO::FETCH_BOTH);
       foreach ($connect->query($sql)as $field){
            echo $field['name'];
            echo $field['id']."<br>";
            
       }
    //    print_r($result);
    ?>
</body>
</html>