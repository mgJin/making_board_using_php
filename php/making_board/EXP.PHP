<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>
<body>
    <form id="form1">
        <input name="ti">
        <input name="ss">
        <input id="btn" type="button" value="click">
    </form>
    <script>
        $("#btn").on("click",function(){
            $.ajax({
                type:"POST",
                url:"http://localhost:3000/EXP2.php",
                data:{
                    "title":$("input[name='ti']").val()
                },
                success:function(result){
                    console.log(result);
                }
            })
        })
    </script>
</body>
</html>