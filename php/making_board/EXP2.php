<?php 
$params = array(
   ":id" => "signuptest1234",
   ":name" => "sign",
   ":password" => "ds",
   ":gender" => "male",
   ":birth" => "2024-02-27",
   ":email" => "asdas@gmaild.com"
);

foreach($params as $param =>$value){
   echo $param;
   echo "<Br>";
   echo $value;
   echo "<Br>";
}

?>