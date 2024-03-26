<?php
    global $connect;
    $sql = "SELECT user_pk,user_id,role_id FROM member";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $userArrays = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
<link rel='stylesheet' href='/front/css/management.css' type='text/css'>
</head>

<body>
    <div id="UserManagement" class="managements">
        <nav>
            <ul>
                <?php foreach ($userArrays as $userInfo) { ?>
                    <li class="management-li list-li">
                        <a class="infoA" href='<?= BASE_URL."/adminpage/userinfo/" . $userInfo['user_pk']?>'>
                            <?php echo $userInfo["user_id"] ?>
                        </a>
                        <button class="del-btn" onclick="delfetch('<?= $userInfo['user_id']; ?>')">X</button>
                    </li>
                <?php }; ?>
            </ul>
        </nav>
    </div>
    <script>
        
        function delfetch(data){
            const formdata = {
                user_id : data,
                admin : true
            }
            fetch("<?= BASE_URL?>/adminpage/usermanagement",{
                method:"DELETE",
                body:JSON.stringify(formdata)
            })
            .then(response=>response.json())
            .then(data=>{
                console.log(data);
                const {serverResponse,deniedReason}= data;
                if(serverResponse){
                    window.location.reload;
                }else{
                    alert(deniedReason);
                }
            }
            )
            .catch(error=>console.log(error));
        }
    </script>
</body>