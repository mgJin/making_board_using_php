<?php 
    $permissionsArray = ['user','board','dele'];
    $result = implode(",",array_fill(0,count($permissionsArray),"?"));
    
?>