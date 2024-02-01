<?php 
    return [
        '' => function (){
            echo '<h1>home page</h1>';
        },
        'login' => [
            '' =>function (){
                echo "로그인 안의 것";
            },
            'aa' =>function(){
                // require_once('EXP.PHP');
            },
            'bb' =>function(){
                // require_once('EXP2.php');
            }
        ]
        ,
        'board' =>[
            '' =>function(){
                require_once('view_all_board.php');
            }
        ]
       
    ];
?>