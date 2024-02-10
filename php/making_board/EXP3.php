<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</head>
<body>
    
    <form id="fm">
        <button id="btn">클릭</button>
    </form>
    <script>
        $("#btn").on("click",async function(e){
            e.preventDefault();
            await $.ajax({
                method:"put",
                url:"http://localhost:3000/EXP4.php",
                data:{
                    "id" : "20"
                },   
                success:function(result){
                    
                    console.log(result);
                }
            });
            
        })
    </script>
</body>
</html>