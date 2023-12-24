<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { 
        
    //입력 검증
    if(empty($_POST["name"])){
        $nameMsg = "비어있음"; 
    }else{
        $name = $_POST["name"];
        
    }
    echo $name;
    }
    ?>
    
        
    <?php  ?>
</body>
</html>