<?php
//PDO 방식
    $servername = "localhost";
    $dbname = "phpboard";
    $user = "root";
    $password = "9094";
    try {
        $connect = new PDO("mysql:host=$servername;dbname=$dbname", $user, $password);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        echo "DB연결실패" . $ex->getMessage();
    }
?>