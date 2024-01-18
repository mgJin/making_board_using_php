<?php 
//mysqli 방식
    function dbconnect($user){
        $servername = "localhost";
        $dbname = "phpboard";
        $connect = mysqli_connect($servername,$user["user_id"],$user["user_pw"],$dbname);
        return $connect;
    }
    
?>