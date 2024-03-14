
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indivisual board Page</title>
    <style>
        .info {
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 20px;
            width: 50%;
            position: relative; 
        }

        .info div {
            margin-bottom: 10px;
        }

        .info label {
            font-weight: bold;
        }

        .delete-button {
            background-color: #dc3545;
            color: #fff;
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            position: absolute;
            bottom: 5px;
            right: 5px;
        }
    </style>
</head>
<body>
    <?php 
        global $connect;

        $sql = "SELECT id,title,text,writer,created FROM board WHERE id=:boardID LIMIT 1";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':boardID',$boardID);
        $stmt->execute();
        $boardInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // print_r($boardInfo);  
    ?>
     <h1>게시물 정보</h1>

<div class="info">
        <div>
            <label>ID:</label> <?php echo $boardInfo["id"];?>
        </div>
        <div>
            <label>Title:</label> <?php echo $boardInfo["title"];?>
        </div>
        <div>
            <label>Text:</label> <?php echo $boardInfo["text"];?>
        </div>
        <div>
            <label>Writer:</label> <?php echo $boardInfo["writer"];?>
        </div>
        <div>
            <label>Created:</label> <?php echo $boardInfo["created"];?>
        </div>
        <button class="delete-button" onclick="deletePost(1)">삭제</button>
    </div>
</body>
</html>