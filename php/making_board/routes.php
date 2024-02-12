<?php 
    return [
        '/' => [
            'get'=> function (){
                echo '<h1>home page</h1>';
            }
        ],
        '/board' => [
            'get'=> function(){
                include('view_all_board.php');
            },
            'post'=>function(){
                echo '<h1>post page</h1>';
            }
        ],
        '/board/postForm'=>[
            'get'=>function(){
                include('posting.php');
            }
        ],
        '/board/([0-9]+)'=>[
            'get'=> function($var){
               include('view_board.php');
            },
            'put'=>function(){
                echo '<h1>put page</h1>';
            },
            'delete'=>function(){
                echo '<h1>delete page</h1>';
            }
        ],
        '/board/([0-9]+)/updateForm'=>[
            'get'=>function(){
                include('update_form');
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
                include('login.php');
            },
            'post'=>function(){
                include('login_post.php');
            }
        ],
        '/logout' =>[
            'post'=>function(){
                include('logout.php');
            }
        ]
        
    ];
?>