<?php 
    return [
        '/' => [
            'get'=> function (){
                echo '<h1>home page</h1>';
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
                echo "<h1>user 정보 수정 페이지</h1>";
            }
        ],
        // '/me/updateForm'=>[
        //     'get'=>function(){
        //         echo "<h1>user 정보 수정 기입 페이지</h1>";
        //     }
        // ],
        '/userSignup' =>[
            'get'=>function(){
                include(__DIR__.'/../User/UserSignUpForm.php');
            },
            'post'=>function(){
                include(__DIR__.'/../User/userPost.php');
            }
        ],
       
        
        
    ];
?>