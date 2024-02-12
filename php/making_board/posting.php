<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시물등록</title>
</head>
    
<body>
    <!--user_id 를 유니크로 만들고 글을 작성 시 writer 에 user_id를 넣는 식으로 -->
    <!--로그인을 안하고 들어왔다면 로그인으로 가게하기 -->
    <?php
        session_start();
        if(!(isset($_SESSION["is_loggedin"]) && $_SESSION["is_loggedin"])){
            echo "<script>alert('로그인을 해주세요');
            location.href='login.php'</script>";
        }

        $titleMsg = "";
        //입력검증
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
                $writer = $_SESSION["user"]["user_id"];
                $date = date("Y-m-d");
                $servername = "localhost";
                $dbuser = "root";//퍼블릭 유저로 바꾸기
                $password = "9094";
                $dbname = "phpboard";
                try{
                    $mysqliconnect = mysqli_connect($servername,$dbuser,$password,$dbname);
                    $sql = 
                    "INSERT INTO board
                        set title = '$title',
                            text = '$text',
                            created = '$date',
                            writer = '$writer'
                    ";
                    $stmt = mysqli_prepare($mysqliconnect,$sql);
                    $exec = mysqli_stmt_execute($stmt);
                    echo "<script>alert('글쓰기성공');
                    location.href='view_all_board.php'</script>";
                }catch(mysqli_sql_exception $ex){
                    echo "디비실패이유: ".$ex->getMessage();
                }catch(Exception $ex){
                    echo "실패 이유 : ".$ex->getMessage();
                }
            }
            // $mysqliconnect = mysqli_connect($servername,$dbuser,$password,$dbname);
            // if(!$mysqliconnect){
            //     die("서버연결실패 : ".mysqli_connect_error());
            // }
            // echo "서버연결성공"."<br>";
        }
    ?>
    <form action = "http://localhost:3000/board" method="post">
        제목 : <input type = "text" name = "title">
        <?php echo $titleMsg;?>
        내용 : <input type = "text" name = "text">
        <input type = "submit" value="글쓰기">
    </form>
</body>
</html>