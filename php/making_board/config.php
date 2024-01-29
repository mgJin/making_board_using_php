<?php
//PDO 방식
//이걸 권한을 제한한 유저를 만든 다음 하는게 좋을듯?
    $servername = "localhost";
    $dbname = "phpboard";
    $user = "root";
    $password = "9094";
    
    $connect = new PDO("mysql:host=$servername;dbname=$dbname", $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
?>