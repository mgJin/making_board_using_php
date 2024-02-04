<?php require('config.php');?>
    <?php include('permission_functions.php');?>
    <?php

        function chk(){
            global $connect;
            //로그인이 되어있을 경우
            $result = true;
            if($_SERVER['REQUEST_METHOD']=="POST"){
                //로그인이 필요한지 (이거 로그인도 막고 있음)
                // if(!(isset($_SESSION['user_id']))){
                //     echo "<script>alert('로그인이 필요합니다')</script>"; //현재페이지로 다시 이동
                //     $result = false;
                //     return $result;
                // }
                $user_id = $_SESSION['user_id'];
                
                $role_id = getRoleId($connect,$user_id);
                
                $permissionsArray = getRolesPermissions($connect,$role_id);
                
                if(canUpdateUser($permissionsArray)){
                    echo "성공";
                    $result = true;
                }else{
                    echo "한 번 더";
                }
            }
            return $result;
        }
    ?>