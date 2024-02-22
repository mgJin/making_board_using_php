<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시물등록</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>
    
<body>
    <!--user_id 를 유니크로 만들고 글을 작성 시 writer 에 user_id를 넣는 식으로 -->
    <!--로그인을 안하고 들어왔다면 로그인으로 가게하기 -->
    
    <form id="posting-form" onsubmit="return false">
        제목 : <input type = "text" name = "title" required>
        
        내용 : <input type = "text" name = "text">
        <input id="posting-btn" type="button" value="글쓰기">
    </form>
    <!--form action을 jquery로 작동을 하게 한다.
        제목이 비었을 시 버튼을 눌러도 작동을 하지 않게 하고 동시에 경고문을 띄우도록
    -->
    <script>
        //글쓰기 클릭 시 ajax
        $("#posting-btn").on("click",function(event){
            $.ajax({
                type:"POST",
                url:"http://localhost:3000/boards",
                data:{
                    title:$("input[name='title']").val(),
                    text:$("input[name='text']").val()
                },
                success:function(result){
                    console.log(result);
                    const r = result.replace(/}{/g,',');
                    const rp = JSON.parse(r);
                    const {mwResponse,deniedReason,serverResponse}= rp;
                    if(!mwResponse){
                        alert(deniedReason);
                        return;
                        //여기서 그냥 로그인 화면으로 이동하게 할까? 한번물어보고
                        //아 근데 로그인 으로 이동하게 하려면 로그인을 또 걸러야함
                    }
                    if(!serverResponse){
                        alert(deniedReason);
                        return;
                    }
                    alert('게시글이 등록되었습니다');
                    window.location.replace("http://localhost:3000/boards");
                    //이제 다 통과 됐으니깐 실행해야할 것들 
                },
                error:function(result,status,error){
                    console.log(error);
                }
            })
        });
    </script>
</body>
</html>