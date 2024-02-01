<?php 
    

    return [ (object)array(

        'path' => '/',
        'source' =>function(){
            echo "첫페이지";
        },
        'children' =>[
            (object)array(
                'path' =>'login',
                'source'=>function(){
                    echo "login페이지";
                },
                'children' =>[
                    (object)array(
                        'path' =>'aa',
                        'source' =>function(){
                            echo "aa페이지";
                        }
                    )
                ]
                    ),
            (object)array(
                'path' =>'main',
                'source' =>function(){
                    echo "main페이지";
                },
            )
        ]
    )
    ]
?>