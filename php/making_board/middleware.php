<?php require('config.php');?>
    <?php include('permission_functions.php');?>
    <?php

        function chk(){
            global $connect;
            //로그인이 되어있을 경우
            $result = true;
        
            // 로그인이 필요한지 (이거 로그인도 막고 있음)
            if(isset($_POST['cud-action'])){
                session_start();
                var_dump($_SESSION);
                if(!(isset($_SESSION['is_loggedin']))){
                    echo "<script>alert('로그인이 필요합니다')</script>"; //현재페이지로 다시 이동
                    
                    $result = false;
                    return $result;
                }

                $user_id = $_SESSION['user']['user_id'];
                
                $role_id = getRoleId($connect,$user_id);
                
                $permissionsArray = getRolesPermissions($connect,$role_id);
                var_dump($permissionsArray);
                if(in_array($_POST['cud-action'],$permissionsArray)){
                    $result = true;
                    
                }else{
                    $result = false;
                }

            }
            return $result;
        }
        
    ?>