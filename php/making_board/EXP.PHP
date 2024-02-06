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
                    // $("#exp-form").attr("action","http://localhost:3000/exp3");
                    // $("#exp-form").submit();
                    console.log(result); //여기서 result 를 받고 이게 트루면 그대로 진행하고 아니면 거부됐다는 것을 알리면 된다.
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