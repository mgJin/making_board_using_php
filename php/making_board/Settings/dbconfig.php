<?php
//유저한테 보이는 Form은 첫 글자부터 대문자
//행동이 들어가면 첫글자는 소문자
//PDO 방식

    $servername = "localhost";
    $dbname = "phpboard";
    $user = "root";
    $password = "9094";
    
    $connect = new PDO("mysql:host=$servername;dbname=$dbname", $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
?>