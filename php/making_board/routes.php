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
        '/board/([0-9]+)'=>function($var){
           include('view_board.php');
        },
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