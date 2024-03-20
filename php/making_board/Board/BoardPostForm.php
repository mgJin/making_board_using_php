
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
        event.preventDefault();
        const baseURL = "<?= BASE_URL?>/boards";
        
        $.ajax({
            type:"POST",
            url: baseURL,
            contentType:'application/json',
            data:JSON.stringify({
                title:$("input[name='title']").val(),
                text:$("input[name='text']").val()
            }),

            dataType:'json',
            success:function(result){
                
                const {mwResponse,deniedReason,serverResponse,boardID}= result;
                
                //mwResponse가 undefined일 때가 있으므로 ==false로  
                if(mwResponse==false){
                    console.log(deniedReason);
                    alert(deniedReason);
                    return;
                }
                if(serverResponse){
                    alert('게시되었습니다');
                    window.location.replace(baseURL+"/"+boardID);
                }else{
                    console.log(deniedReason);
                    alert('서버문제');
                }
            },
            error:function(result,status,error){
                console.log(result);
                console.log(status);
                console.log(error);
            }
        })
    });
</script>
