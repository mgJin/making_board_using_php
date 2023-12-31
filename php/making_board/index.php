<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>전체게시판보기</title>
</head>
<body>
    
    <?php 
        //처음 들어왔다면 페이지 0으로, 페이지 누를 때마다 session 에 묶던가 get에 묶어서 보낸다.
        //페이지수를 n, min max 를 5n+1 과 5n+5(done)
        //페이지가 2까지밖에 없는데 3으로 넘어오면(url에 적어서) 최대페이지로 넘어가게 하면 된다.   
        //dbuser 가 현재 사용중인 client의 id로 
        //select @rown~~~query 로 보여주기 (done)
        //해당 글을 누를때 board 의 pk 가 할당이 되어있어서 어떤 글인지 볼 수 있게(done)
        $currentpage = 0;//현재 페이지
        
        $DIVIDENUM = 3;//한 번에 몇 개의 게시판이 보여지는 가
        if(isset($_GET["page"])){
            $currentpage = $_GET["page"];
        }
        
        $MIN = $DIVIDENUM * $currentpage + 1;
        $MAX = $DIVIDENUM * $currentpage + $DIVIDENUM;
        //db 연결
        $servername = "localhost";
        $dbuser = "root";//client user 로 바꿀 필요있음
        $password = "9094";
        $dbname = "phpboard";
        try{
            $connect = mysqli_connect($servername,$dbuser,$password,$dbname);
            $viewsql = 
                "SELECT id,title 
                    FROM (SELECT @ROWN:=@ROWN+1 AS rown,id,title 
                            FROM board,(SELECT @ROWN:=0) TEMP) ROWBOARD 
                    WHERE rown>='$MIN' AND rown<='$MAX'";
            //전체 개수 조회 (검색추가 하려면 여기서 IF 로 분기태우자)
            $countsql = 
                "SELECT COUNT(id) FROM BOARD";
            $results = $connect->query($viewsql);
            $count_results = $connect->query($countsql);
            // var_dump($results->fetch_all(MYSQLI_ASSOC));
        }catch(mysqli_sql_exception $ex){
            echo "디비실패".$ex->getMessage();
        }
        
    ?>
    
    <?php
    //반복문으로 a 태그 여러개  띄우기(done)
    //a태그 부분 좀 더 깔끔하게 안될까?
    //세로로 배열필요
    foreach($results as $result){
        $baseurl = "http://localhost:3000/view_board.php";
        $url = $baseurl ."?id=".$result["id"];
    ?>
    <a href=<?php echo $url ?>><?php echo $result["title"] ?></a>
    <?php } ?>
    <!-- 이제 페이지 넘기는 것을 만들 차례-->
    <!-- get으로 page를 넘기면 된다-->
    
    <a href = <?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?page=1";?>>2</a>
    <?php 
    //최대 5까지만 뜨게 하고 > 로 이동가능하게
        $count = $count_results->fetch_row();
        echo "현재 전체 개수는 : ".$count[0];
        if($count>=5){

        }
    ?>
    

</body>
</html>