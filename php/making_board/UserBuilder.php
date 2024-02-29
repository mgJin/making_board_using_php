<?php 
   
   namespace app\User;

use InvalidArgumentException;

   class User{

      private $id;
      private $name;
      private $password;
      private $email;
      private $gender;
      private $birth;
      public bool $result;
      
      public static function builder(){
         return new UserBuilder();
      }

      public function setID($id){
         $this->id = $id;
      }
      public function getID(){
         return $this->id;
      }

      public function setName($name){
         $this->name = $name;
      }
      public function getName(){
         return $this->name;
      }

      public function setPassword($password){
         $this->password = $password;
      }
      public function getPassword(){
         return $this->password;
      }

      public function setGender($gender){
         $this->gender = $gender;
      }
      public function getGender(){
         return $this->gender;
      }

      public function setEmail($email){
         $this->email = $email;
      }
      public function getEmail(){
         return $this->email;
      }

      public function setBirth($birth){
         $this->birth = $birth;
      }
      public function getBirth(){
         return $this->birth;
      }
      

      public function display(){
         echo "ID : $this->id";
         echo "Name : $this->name";
      }
   }
   //validation이랑 같이 진행하기
   class UserBuilder {
      
      public $user;
      public $result=false;

      public function __construct(){
         $this->user = new User();
      }
      //id의 if에 pregmatch 를 써서 정규식으로 특정 문자들을 막아도 될듯?
      //일단 지금은 strlen 만 해서 입력을 무조건 해야하는 것만 거르자
      public function valID($id){
         if(strlen($id)>0){
            $this->user->setID($id);
            return $this;
         }else{
            throw new InvalidArgumentException('ID를 입력해주세요');
         }
      }
      
      public function valName($name){
         if(strlen($name)):
            $this->user->setName($name);
            return $this;
         else:
            throw new InvalidArgumentException('이름을 입력해주세요');
         endif;
      }
      
      public function valPassword($password){
         if(strlen($password)):
            $this->user->setPassword($password);
            return $this;
         else:
            throw new InvalidArgumentException('비밀번호를 입력해주세요');
         endif;
      }
     
      public function valEmail($email){
         if(empty($email)):
            return;
         endif;
         if(filter_var($email,FILTER_VALIDATE_EMAIL)):
            $this->user->setEmail($email);
            return $this;
         else:
            throw new InvalidArgumentException('email형식이 올바르지 않습니다');
         endif;
      }
      
      public function valGender($gender){
         $this->user->setGender($gender);
         return $this;
      }
      
      public function valBirth($birth){
         $this->user->setBirth($birth);
         return $this;
      }
      
      
      public function build(){
         $this->user->result = true;
         return $this->user;
      }
   }
?>