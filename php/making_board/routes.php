<?php 
    return [
        '/' => [
            'get'=> function (){
                echo '<h1>home page</h1>';
            }
        ],
        '/boards' => [
            'get'=> function(){
                include('Boards.php');
            },
            'post'=>function(){
                include('boardPost.php');
            }
        ],
        '/boards/postForm'=>[
            'get'=>function(){
                include('BoardPostForm.php');
            }
        ],
        '/boards/([0-9]+)'=>[
            'get'=> function($boardID){
               include('BoardDetail.php');
            },
            'put'=>function($boardID){
                include('boardUpdate.php');
            },
            'delete'=>function($boardID){
                include('boardDelete.php');
            }
        ],
        '/boards/([0-9]+)/updateForm'=>[
            'get'=>function($boardID){
                include('BoardUpdateForm.php');
            }
        ],
        
        '/exp1' =>[
            'get'=> function(){
                include('EXP.php');
            }
        ],
        '/exp2' =>[
            'get'=> function(){
                include('EXP2.php');
            }
        ],
        '/exp3' =>[
            'get'=> function(){
                include('EXP3.php');
            }
        ],
        '/login' => [
            'get'=> function(){
                include('LoginForm.php');
            },
            'post'=>function(){
                include('loginPost.php');
            }
        ],
        '/logout' =>[
            'post'=>function(){
                include('logOut.php');
            }
        ],
        '/me'=>[
            'get'=>function(){
                echo "<h1>user 정보 페이지</h1>";
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
        '/user' =>[
            'get'=>function(){
                include('UserSignUpForm.php');
            },
            'post'=>function(){
                include('userPost.php');
            }
        ],
       
        
        
    ];
?>