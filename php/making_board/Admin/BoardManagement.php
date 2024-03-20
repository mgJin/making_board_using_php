<?php 
    global $connect;
    $sql = "SELECT id,title,writer FROM board";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $boardArrays = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<head>
    <link rel='stylesheet' href='/front/css/management.css' type='text/css'>
</head>

<div id="BoardManagement" class="managements">
    <nav>
        <ul>
            <?php foreach ($boardArrays as $boardInfo) { ?>
                <li class="management-li list-li">
                    <a class="infoA" href='<?= BASE_URL."/adminpage/boardinfo/" . $boardInfo['id']?>'>
                        <?php echo $boardInfo["title"] ?>
                    </a>
                    <button class="del-btn">X</button>
                </li>
            <?php }; ?>
        </ul>
    </nav>
</div>