<?php 
    global $connect;
    $sql = "SELECT user_pk,user_id,role_id FROM member";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $userArrays = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body>
    <div id="UserManagement" class="managements">
        <nav>
            <ul>
                <?php foreach ($userArrays as $userInfo) { ?>
                    <li>
                        <a class="infoA" <?php echo "href='http://localhost:3000/adminpage/userinfo/" . $userInfo['user_pk'] . "'"; ?>>
                            <?php echo $userInfo["user_id"] ?>
                        </a>
                    </li>
                    <?php }; ?>
                </ul>
            </nav>
        </div>
</body>