<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    
?>
    <form action ="/view_board.php" method = "post">
        <input type = "text" name = "title">
        <input type = "text" name = "text">
        <input type = "date" name = "created" value="<?php echo date("Y-m-d"); ?>">
        
    </form>
</body>
</html>