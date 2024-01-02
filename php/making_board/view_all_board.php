<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판보기</title>
</head>
<body>
    
    <?php 
        //처음 들어왔다면 페이지 0으로, 페이지 누를 때마다 session 에 묶던가 get에 묶어서 보낸다.
        //dbuser 가 현재 사용중인 client의 id로 
        //select @rown~~~query 로 보여주기 (done)
        //해당 글을 누를때 board 의 pk 가 할당이 되어있어서 어떤 글인지 볼 수 있게
        $min = 1;
        $max = 5;
        $servername = "localhost";
        $dbuser = "root";//client user 로 바꿀 필요있음
        $password = "9094";
        $dbname = "phpboard";
        try{
            $connect = mysqli_connect($servername,$dbuser,$password,$dbname);
            $sql = 
                "SELECT id,title 
                    FROM (SELECT @ROWN:=@ROWN+1 AS rown,id,title 
                            FROM board,(SELECT @ROWN:=0) TEMP) ROWBOARD 
                    WHERE rown>='$min' AND rown<='$max'";
            $results = $connect->query($sql);
            // var_dump($results->fetch_all(MYSQLI_ASSOC));
        }catch(mysqli_sql_exception $ex){
            echo "디비실패".$ex->getMessage();
        }
    ?>
    
    <?php
    //반복문으로 a 태그 여러개  띄우기
    //a태그 부분 좀 더 깔끔하게 안될까?
    foreach($results as $result){
        $baseurl = "http://localhost:3000/view_board.php";
        $url = $baseurl ."?id=".$result["id"];
    ?>
    <a href=<?php echo $url ?>><?php echo $result["title"] ?></a>
    <?php } ?>
</body>
</html>