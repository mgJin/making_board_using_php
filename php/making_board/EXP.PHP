<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>
<body>
    <!--모달창을 만들자 -->
    <form id="btn_form">
        <button class="crdbtn" id="updbtn">수정</button>
        <button class="crdbtn" id="delbtn">삭제</button>
    </form>
    <script>
        locrep(msg,function(result){
                if(result){
                    window.location.replace("http://www.naver.com");
                }
        })
        $(".crdbtn").on("click",function(event){
            const beh = event.target.innerText;
            
            // let chk = confirm(beh+"하시겠습니까?",function(result){
            //     if(result){
            //         window.location.replace("http://www.naver.com");
            //     }else{
            //         window.location.replace("http://www.google.com");
            //     }
            // });
            var locrep = function(beh,callback){
                confirm(beh,function(result){
                    locrep(result);
                })
            }
        })
    </script>

</body>
</html>