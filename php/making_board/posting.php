<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시물등록</title>
</head>
    
<body>
    <?php 
        $titleMsg = "";
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $dbconnect= true;
            if(!$_POST["title"]){
                $titleMsg = "제목을 입력해주세요";
                $dbconnect = false;
            }else{
                $title = $_POST["title"];
            }
            $text = $_POST["text"];
            if($dbconnect){
                $date = date("Y-m-d");
                $servername = "localhost";
                $dbuser = "root";//client user 로 바꿀 필요있음
                $password = "9094";
                $dbname = "phpboard";
                try{
                    $connect = mysqli_connect($servername,$dbuser,$password,$dbname);
                    $sql = 
                    "INSERT INTO board
                        set title = '$title',
                            text = '$tertxt',
                            created = '$date',
                            writer = '1'
                    ";
                    $stmt = mysqli_prepare($connect,$sql);
                    $exec = mysqli_stmt_execute($stmt);
                    echo "디비성공";
                }catch(mysqli_sql_exception $ex){
                    echo "디비실패이유: ".$ex->getMessage();
                }catch(Exception $ex){
                    echo "실패 이유 : ".$ex->getMessage();
                }
            }
            // $connect = mysqli_connect($servername,$dbuser,$password,$dbname);
            // if(!$connect){
            //     die("서버연결실패 : ".mysqli_connect_error());
            // }
            // echo "서버연결성공"."<br>";
        }
    ?>
    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        제목 : <input type = "text" name = "title">
        <?php echo $titleMsg;?>
        내용 : <input type = "text" name = "text">
        글쓰기 : <input type = "submit">
    </form>
</body>
</html>