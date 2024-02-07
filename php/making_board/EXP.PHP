<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>
<body>

    <form id="exp-form">
        <button id = "form-button">클릭</button>
    </form>
    <script>
        $("#form-button").on("click",async function(event){
            event.preventDefault();
            await $.ajax({
                type : "POST",
                url : "http://localhost:3000/exp2",
                data : {
                    'cud-action' : 'update-board'
                },
                
                success : function(result){
                    //json 으로 받은게 두개, {}{} 형태라서 중간의 }{를 없애고 ',' 로 대체해서 하나의 object로 만듦
                    let r = result.replace(/}{/g,',');
                    
                    let rp = JSON.parse(r);
                    const {mwResponse,serverResponse} = rp;
                    console.log(mwResponse,serverResponse);
                    if(!mwResponse){
                        alert("권한이 없습니다.");
                    }else{
                        if(!serverResponse){
                            alert('서버 문제');
                        }else{
                            $("#exp-form").attr("action","http://localhost:3000/exp3");
                            $("#exp-form").submit();
                        }
                    }
                    
                },
                error : function(result,status,error){
                    console.log(error);
                }
            });
            
        });
    </script>
</body>
</html>