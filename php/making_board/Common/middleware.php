<?php require(__DIR__.'/../Settings/dbconfig.php');?>
    <?php include('permission_functions.php');?>
    <?php
        //해당 url로 들어와도 되는지, 권한이 있는지 체크하는 미들웨어 함수
        //접근 권한이 없을 때에는 무조건 boards 페이지를 보게 한다던지 아니면 다른 수단이 필요할듯?
        function chk(){
            
            global $connect;
            //로그인이 되어있을 경우
            $result = false;
            $url = parse_url($_SERVER['REQUEST_URI']);
            $url = $url['path'];
            //기본적으로 get요청은 모두 통과
            if($_SERVER['REQUEST_METHOD']=="GET"){
                $result = true;
            }
            
            if(preg_match('/^\/adminpage(\/.*)?$/',$url)):
                session_start();
                if(!isset($_SESSION['is_loggedin'])):
                    return $result=false;
                endif;
                $user_id = $_SESSION["user"]["user_id"];
                
                $role_id = getRoleId($connect,$user_id);
                if($role_id==1):
                    return $result=true;
                else:
                    $resultArray = [
                        'mwResponse'=>false,'deniedReason'=>'not admin'
                    ];
                    echo jsonMaker($resultArray);
                    return $result=false;
                endif;
            endif;
                
            //me나 admin은 여기서 막을 것
            if(preg_match('/^\/me(\/.*)?$/',$url)):
                session_start();
                //login하지 않고 들어갈 시 mw에서 막힘
                if(isset($_SESSION["is_loggedin"])):
                    return $result = true;
                else:
                    return $result = false;
                endif;
            endif;
            
            
            
            //get으로 들어올 때 막는것 (예를 들어 관리자페이지)은 따로 해야할 듯?
            //create는 필요한것이 로그인 되어있나, 생성할 권한이 있냐에 따라 결정됨
            //update,delete는 로그인 + 권한 + 해당 게시물(board에 한해서)의 writer인지 알아볼 필요가있음
            if($_SERVER['REQUEST_METHOD']!="GET"){
                // header('Content-Type:application/json');
                session_start();
                //로그인 요청,회원가입은 통과시켜주기
                $login_array = array('/loginForm','/logout','/signupform');
                if(in_array($url,$login_array)){
                    $result = true;
                    return $result;
                }
                //로그인 확인
                if(!(isset($_SESSION['is_loggedin']))||$_SESSION['is_loggedin']==false){
                    //현재페이지로 다시 이동
                    $result = false;
                    $echoresult = ["mwResponse"=>$result,"deniedReason"=>"not login"];
                    echo jsonMaker($echoresult);
                    return $result;
                }
                
                //권한 받아오기
                $user_id = $_SESSION['user']['user_id'];
                
                $role_id = getRoleId($connect,$user_id);
                
                $permissionsArray = getRolesPermissions($connect,$role_id);
                //지금 하는 행동에 대한 권한이 있는지 매치시키기
                $method = strtolower($_SERVER["REQUEST_METHOD"]);
                
                //role 이 admin이면 바로 통과
                //??이거를 나중에 admin화면으로 갈 때도 적용해야 할 거같은데 밖으로 뺄까?
                if($role_id===1){
                    $result = true;
                    return $result;
                }
                //게시판 관련 permissions
                //여기서 matches 의 첫번째 요소를 그냥 쓸 수는 없나 . 그냥 [0] 으로 지정하니깐 좀 그렇네
                if(preg_match('/^\/boards(?:\/(\d+))?$/',$url,$matches)){
                    $board_id=null;
                    
                    array_shift($matches);
                    if(count($matches)){
                        $board_id = $matches[0];
                    }
                    $array_method = [
                        "post"=>canCreateBoard($permissionsArray)
                        ,
                        "put"=>canUpdateBoard($permissionsArray,$board_id,$user_id,$connect)    
                        ,
                        "delete"=>canDeleteBoard($permissionsArray,$board_id,$user_id,$connect)
                    ];

                    $result = $array_method[$method];
                    
                    if(!$result){
                        $echoresult = ["mwResponse"=>$result,"deniedReason"=>$result?null:"no permission"];
                        echo jsonMaker($echoresult);
                    }
                }
            }
            return $result;
        }
        //배열을 json으로 만들어 주는 함수
        
    ?>