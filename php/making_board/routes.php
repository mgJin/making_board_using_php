<?php 
    return [
        '/' => function (){
            echo '<h1>home page</h1>';
        },
        '/login' => function(){
            include('login.php');
        }
        ,
        '/board' => function(){
            echo '<h1>board page</h1>';
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