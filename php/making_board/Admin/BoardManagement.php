<?php 
    global $connect;
    $sql = "SELECT id,title,writer FROM board";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $boardArrays = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="BoardManagement" class="managements">
    <nav>
        <ul>
            <?php foreach ($boardArrays as $boardInfo) { ?>
                <li>
                    <a class="infoA" <?php echo "href='http://localhost:3000/adminpage/boardinfo/" . $boardInfo['id'] . "'"; ?>>
                        <?php echo $boardInfo["title"] ?>
                    </a>
                </li>
            <?php }; ?>
        </ul>
    </nav>
</div>