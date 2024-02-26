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
        $("#btn").on("click",function(e){
            e.preventDefault();
            $.ajax({
                method:"put",
                url:"http://localhost:3000/EXP4.php",
                data:{
                    "id" : "20"
                },
                
                success:function(result){
                    
                    console.log(result);
                    var sanitizedData = stripHtmlTags(result);
                    console.log(sanitizedData);
                },error:function(xhr,status,error){
                    console.log("xhr: " + xhr);
                    console.log("status: " +status);
                    console.log("error :"+ error);
                }
            });
            
        })
        function stripHtmlTags(html){
            var doc = new DOMParser().parseFromString(html,'text/html');
            return doc.body.textContent || "";
        }
    </script>
</body>
</html>