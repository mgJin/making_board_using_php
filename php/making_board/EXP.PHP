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
                    r = JSON.parse(result);
                    if(r){
                        $("#exp-form").attr("action","http://localhost:3000/exp3");
                        $("#exp-form").submit();
                    }else{
                        alert("권한이 없습니다.");
                    }
                },
                error : function(result,status,error){
                    console.log(error);
                }
            });
            console.log("ajax 바로 밑");
            // $("#exp-form").attr("action","http://localhost:3000/exp3");
            // $("#exp-form").submit();
        });
    </script>
</body>
</html>