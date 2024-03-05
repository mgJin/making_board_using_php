
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indivisual board Page</title>
</head>
<body>
    <?php 
        global $connect;

        $sql = "SELECT id,title,text,writer,created FROM board WHERE id=:boardID LIMIT 1";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':boardID',$boardID);
        $stmt->execute();
        $boardInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        print_r($boardInfo);  
    ?>
    
</body>
</html>