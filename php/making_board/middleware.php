<?php require('config.php');?>
    <?php include('permission_functions.php');?>
    <?php

        function chk(){
            global $connect;
            //로그인이 되어있을 경우
            $result = true;
            
            // 로그인이 필요한지 (이거 로그인도 막고 있음)
            //method 로 구분을 지을것
            //get으로 들어올 때 막는것 (예를 들어 관리자페이지)은 따로 해야할 듯?
            //create는 필요한것이 로그인 되어있나, 생성할 권한이 있냐에 따라 결정됨
            //update,delete는 로그인 + 권한 + 해당 게시물(board에 한해서)의 writer인지 알아볼 필요가있음
            if($_SERVER['REQUEST_METHOD']!="GET"){
                session_start();
                //로그인 요청은 통과시켜주기
                if(parse_url($_SERVER['REQUEST_URI'])['path']=='/login'||'/logout'){
                    return $result;
                }
                //로그인 확인
                if(!(isset($_SESSION['is_loggedin']))||$_SESSION['is_loggedin']==false){
                    //현재페이지로 다시 이동
                    
                    $result = false;
                    $echoresult = ["mwResponse"=>$result,"deniedReason"=>"not login"];
                    echo json_encode($echoresult,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
                    return $result;
                }
                
                //권한 받아오기
                $user_id = $_SESSION['user']['user_id'];
                
                $role_id = getRoleId($connect,$user_id);
                
                $permissionsArray = getRolesPermissions($connect,$role_id);
                //지금 하는 행동에 대한 권한이 있는지 매치시키기
                $method = strtolower($_SERVER["REQUEST_METHOD"]);
                if(in_array($_POST['cud-action'],$permissionsArray)){
                    $result = true;
                    $echoresult = ["mwResponse"=>$result];
                    echo json_encode($echoresult,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
                }else{
                    $result = false;
                    $echoresult = ["mwResponse"=>$result];
                    echo json_encode($echoresult,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
                }

            }
            return $result;
        }
        
    ?>