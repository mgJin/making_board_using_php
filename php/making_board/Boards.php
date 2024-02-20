<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>전체게시판보기</title>
</head>

<body>
    <!-- 게시글 목록 보여주기-->
    <?php
    //페이지가 2까지밖에 없는데 3으로 넘어오면(url에 적어서) 최대페이지로 넘어가게 하면 된다.   
    //dbuser 가 현재 사용중인 client의 id로 
    session_start();
    include('log_inout_button.php');
    $currentpage = 1; //현재 페이지와 맨 처음 들어왔을 때 보여지는 페이지
    $DIVIDENUM = 1; //한 번에 몇 개의 게시글이 보여지는 가
    if (isset($_GET["page"])) {
        $currentpage = $_GET["page"];
    }
   
    //db 연결
    $servername = "localhost";
    $dbuser = "root"; 
    $password = "9094";
    $dbname = "phpboard";
    //전체 게시판 개수 조회
    try{
        $viewAllBoardConnect= mysqli_connect($servername, $dbuser, $password, $dbname);
        $countsql =
        "SELECT COUNT(id) FROM BOARD";
        $count_results = $viewAllBoardConnect->query($countsql);
    } catch(mysqli_sql_exception $ex){
        echo "디비실패 ".$ex->getMessage();
    }
    $count = $count_results->fetch_row();
    
    //게시판 글 수를 한번에 보여줘야할 수로 나누어서 maxbar 계산
    //전체 게시판 글 수
    $MAXBOARD = (int)$count[0]; 
    //표시되어야 할 barnum의 최대 개수
    $MAXNUM = (int)($MAXBOARD / $DIVIDENUM); 
    //계산에서는 현재 페이지에서 -1 을 뺀 숫자를 이용
    $CALNUM = $currentpage - 1;
    if($MAXNUM < $currentpage){
        $CALNUM = $MAXNUM-1;
    }
    if($CALNUM<0){
        $CALNUM = 0;
    }
    $MINROW = $DIVIDENUM * $CALNUM + 1; //현재 페이지에서 보여줄 게시글의 최소 row수
    $MAXROW = $DIVIDENUM * $CALNUM + $DIVIDENUM; //현재 페이지에서 보여줄 게시글의 최대 row수

    //해당 페이지 게시글 조회
    try {
        $viewAllBoardConnect = mysqli_connect($servername, $dbuser, $password, $dbname);
        $viewsql =
            "SELECT id,title 
                    FROM (SELECT @ROWN:=@ROWN+1 AS rown,id,title 
                            FROM board,(SELECT @ROWN:=0) TEMP) ROWBOARD 
                    WHERE rown>='$MINROW' AND rown<='$MAXROW'";
        //전체 개수 조회 (검색추가 하려면 여기서 IF 로 분기태우자)
       
        $results = $viewAllBoardConnect->query($viewsql);
    } catch (mysqli_sql_exception $ex) {
        echo "디비실패" . $ex->getMessage();
    }
    ?>

    <!-- 게시글 목록만들기 -->
    <?php
    //게시글 목록에서 클릭 시 게시글에 연결
    //a태그 부분 좀 더 깔끔하게 안될까?
    //세로로 배열필요
    foreach ($results as $result) {
        $baseurl = "http://localhost:3000/boards";
        $url = $baseurl . "/" . $result["id"];
    ?>
        <a href=<?php echo $url ?>><?php echo $result["title"] ?></a>
    <?php } ?>

    <!-- 이제 페이지 넘기기-->
    <?php
    
    $BARRANGE = 2; //한 번에 보여줄 BARNUMBER의 개수
    
    if(!($MAXBOARD%$DIVIDENUM===0)){
        $MAXNUM+=1;
    }
    $prevpage = $currentpage - 1;
    $nextpage = $currentpage + 1;
    if($nextpage>=$MAXNUM){
        $nextpage = $MAXNUM;
    }
    //최대값 넘어가면 최대값으로 고정
    $SHARE = (int)($CALNUM / $BARRANGE);
    //barnum 보여주는 반복문
    for ($i = 0; $i < $BARRANGE; $i++) {
        $barnum = $BARRANGE * $SHARE + $i + 1;
        if ($MAXNUM < $barnum) {
            echo "최대값을 넘어가려함";
            break;
        }

    ?>
        <a href=<?php echo "http://localhost:3000/boards"."?page=" . $barnum; ?>><?php echo $barnum; ?>&nbsp;</a>

    <?php } ?>

    <!-- 화살표로 숫자넘어가기 필요-->
    <a href= <?php echo "http://localhost:3000/boards"."?page=1";?>><<</a>
    <a href= <?php echo "http://localhost:3000/boards"."?page=".$prevpage;?>><</a>
    <a href= <?php echo "http://localhost:3000/boards"."?page=".$nextpage;?>>></a>
    <a href= <?php echo "http://localhost:3000/boards"."?page=".$MAXNUM?>>>></a>
    <!-- 상수들 합치기 -->
    <button onclick="location.href='http:\/\/localhost:3000/boards/postForm'">글쓰기</button>
    
    <script>
        if(document.querySelector("#logoutBtn")){
            document.querySelector("#logoutBtn").addEventListener(
                "click",
                function(){
                    form = document.createElement("form");
                    form.setAttribute("action","http://localhost:3000/logout");
                    form.setAttribute("method","POST");
                    document.body.appendChild(form);
                    form.submit();
                }
            )
        }
    </script>
</body>

</html>