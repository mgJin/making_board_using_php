<?php 
    return [
        '/' => [
            'get'=> function (){
                echo '<h1>home page</h1>';
            }
        ],
        '/adminpage'=>[
            'get'=>function(){
                include(__DIR__.'/../Admin/admin.php');
            }
        ],
        '/adminpage/rolemanagement'=>[
            'get'=>function(){
                include(__DIR__.'/../Admin/RoleManagement.php');
            },
            'post'=>function(){
                include(__DIR__.'/../Admin/rolePost.php');
            },
            'put'=>function(){
                include(__DIR__.'/../Admin/roleUpdate.php');
            },
            'delete'=>function(){
                include(__DIR__.'/../Admin/roleDelete.php');
            }
        ],
        '/adminpage/rolemanagement/event'=>[
            'post'=>function(){
                include(__DIR__.'/../Admin/roleRadioClickEvent.php');
            }
        ],
        '/adminpage/boardmanagement'=>[
            'get'=>function(){
                include(__DIR__.'/../Admin/BoardManagement.php');
            }
        ],
        '/adminpage/boardinfo/([0-9]+)'=>[
            'get'=>function($boardID){
                include(__DIR__.'/../Admin/BoardInfoDetail.php');
            }
        ],
        '/adminpage/usermanagement'=>[
            'get'=>function(){
                include(__DIR__.'/../Admin/UserManagement.php');
            },
            'delete'=>function(){
                include(__DIR__.'/../User/userDelete.php');
            }
        ],
        '/adminpage/userinfo/([0-9]+)'=>[
            'get'=>function($user_pk){
                include(__DIR__.'/../Admin/UserInfoDetail.php');
            },
            'put'=>function($user_pk){
                include(__DIR__.'/../Admin/userInfoUpdate.php');
            }
        ],
        '/boards' => [
            'get'=> function(){
                include(__DIR__.'/../Board/Boards.php');
            },
            'post'=>function(){
                include(__DIR__.'/../Board/boardPost.php');
            }
        ],
        '/boards/postForm'=>[
            'get'=>function(){
                include(__DIR__.'/../Board/BoardPostForm.php');
            }
        ],
        '/boards/([0-9]+)'=>[
            'get'=> function($boardID){
               include(__DIR__.'/../Board/BoardDetail.php');
            },
            'put'=>function($boardID){
                include(__DIR__.'/../Board/boardUpdate.php');
            },
            'delete'=>function($boardID){
                include(__DIR__.'/../Board/boardDelete.php');
            }
        ],
        '/boards/([0-9]+)/updateForm'=>[
            'get'=>function($boardID){
                include(__DIR__.'/../Board/BoardUpdateForm.php');
            }
        ],
        '/loginForm' => [
            'get'=> function(){
                include(__DIR__.'/../Login/LoginForm.php');
            },
            'post'=>function(){
                include(__DIR__.'/../Login/loginPost.php');
            }
        ],
        '/logout' =>[
            'post'=>function(){
                include(__DIR__.'/../Login/logOut.php');
            }
        ],
        '/me'=>[
            'get'=>function(){
                include(__DIR__.'/../User/Me.php');
                //여기 밑에다가 수정버튼을 누르면 수정 페이지가 뜨도록 하자
                //애초에 정보는 다 나오잖아.
            },
            'put'=>function(){
                include(__DIR__.'/../User/userUpdate.php');
            },
            'delete'=>function(){
                include(__DIR__.'/../User/userDelete.php');
            }
        ],
        '/me/updateform'=>[
            'get'=>function(){
                include(__DIR__.'/../User/UserUpdateForm.php');
            }
        ],
        '/signupform'=>[
            'get'=> function(){
                include(__DIR__.'/../User/UserSignUpForm.php');
            },
            'post'=>function(){
                include(__DIR__.'/../User/userPost.php');
            }
        ]
        
        
    ];
?>