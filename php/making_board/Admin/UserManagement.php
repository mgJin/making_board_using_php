<?php 
    global $connect;
    $sql = "SELECT user_pk,user_id,role_id FROM member";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $userArrays = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<head>
    <style>
        .management-li{
            display:block;
        }
        .del-btn{
            background-color: #dc3545;
            float: right;
            color: #fff;
            padding: 5px 10px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div id="UserManagement" class="managements">
        <nav>
            <ul>
                <?php foreach ($userArrays as $userInfo) { ?>
                    <li class="management-li list-li">
                        <a class="infoA" <?php echo "href='http://localhost:3000/adminpage/userinfo/" . $userInfo['user_pk'] . "'"; ?>>
                            <?php echo $userInfo["user_id"] ?>
                        </a>
                        <button class="del-btn">X</button>
                    </li>
                    <?php }; ?>
                </ul>
            </nav>
        </div>
</body>