<?php 
    // file_get_contents("php://input");
    $data = $_POST;
    $arr = array(
        "data"=>$data
    );
    echo json_encode($arr);
    //create-user:'on' 이렇게 되네
    //on 인것들의 array를 만든 다음 db에 있던 role-permission에 해당 하는 것들을 지우고
    //role-permission에 해당 하는 role id에 permission들을 추가
    //update와 insert를 구분하기 위해서 이미 있던 role인지 구분하는게 필요
?>