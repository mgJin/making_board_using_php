<?php 
    return [
        '/' => function (){
            echo '<h1>home page</h1>';
        },
        '/login' => function(){
            include('login.php');
        },
        '/board' => function(){
            include('view_all_board.php');
        },
        '/board/([0-9]+)'=>[
            'get'=> function($var){
               include('view_board.php');
            },
            'post'=>function(){
                echo '<h1>post page</h1>';
            },
            'put'=>function(){
                echo '<h1>put page</h1>';
            },
            'delete'=>function(){
                echo '<h1>delete page</h1>';
            }
        ],
        '/board/([0-9]+)/delete'=>function($var){
            include('delete_board.php');
        },
        '/exp1' =>function(){
            include('EXP.php');
        },
        '/exp2' =>function(){
            include('EXP2.php');
        },
        '/exp3' =>function(){
            include('EXP3.php');
        }
    ];
?>