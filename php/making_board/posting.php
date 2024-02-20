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
    
    <form id="posting-form">
        제목 : <input type = "text" name = "title">
        
        내용 : <input type = "text" name = "text">
        <input type = "submit" value="글쓰기">
    </form>
    <!--form action을 jquery로 작동을 하게 한다.
        제목이 비었을 시 버튼을 눌러도 작동을 하지 않게 하고 동시에 경고문을 띄우도록
    -->
</body>
</html>