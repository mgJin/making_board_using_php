<?php require('config.php');?>
    <?php include('permission_functions.php');?>
    <?php
        $user_id = "testnewone";
        $role_id = getRoleId($connect,$user_id);
        
        $permissionsArray = getRolesPermissions($connect,$role_id);
        
        if(canUpdateUser($permissionsArray)){
            echo "성공";
        }else{
            echo "한 번 더";
        }
    ?>