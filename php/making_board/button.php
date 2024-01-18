<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
        session_start();
        var_dump($_SESSION["userPK"]);
    ?>
    <button onclick="location.href='add_member.php'">회원가입</button>
</body>

</html>