<?php 
    return [
        '' => function (){
            echo '<h1>home page</h1>';
        },
        'login' => function($params = []) {
            echo "ddddd";
            require_once('login.php');
            if('login/aa'){
                echo "들어옴";
            }
        },
       
    ];
?>