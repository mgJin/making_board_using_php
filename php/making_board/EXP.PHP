<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php         
        session_start();
        require_once('dbconnect_user.php');
        $connect = dbconnect($_SESSION['user']);
        $sql = "SELECT * FROM board";
        $result = $connect->query($sql);
        var_dump($result->fetch_all(MYSQLI_ASSOC));
    ?>
   
</body>
</html>