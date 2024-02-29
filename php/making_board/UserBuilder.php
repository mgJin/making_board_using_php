<?php 
   
   namespace app\User;

   class User{

      private $id;
      private $name;
      private $password;
      private $email;
      private $gender;
      private $birth;

      public function __construct(UserBuilder $builder){
         $this->id = $builder->getID();
         $this->name=$builder->getName();
         $this->password = $builder->getPassword();
         $this ->email = $builder->getEmail();
         $this->gender = $builder->getGender();
         $this->birth = $builder->getBirth();
      }
      
      public static function builder(){
         return new UserBuilder();
      }

      public function display(){
         echo "ID : $this->id";
         echo "Name : $this->name";
      }
   }
      
   class UserBuilder {
      private $id;
      private $name;
      private $password;
      private $email;
      private $gender;
      private $birth;

      public function setID($id){
         $this->id = $id;
         return $this;
      }
      public function getID(){
         return $this->id;
      }
      public function setName($name){
         $this->name = $name;
         return $this;
      }
      public function getName(){
         return $this->name;
      }
      public function setPassword($password){
         $this->password = $password;
         return $this;
      }
      public function getPassword(){
         return $this->password;
      }
      public function setEmail($email){
         $this->email = $email;
         return $this;
      }
      public function getEmail(){
         return $this->email;
      }
      public function setGender($gender){
         $this->gender = $gender;
         return $this;
      }
      public function getGender(){
         return $this->gender;
      }
      public function setBirth($birth){
         $this->birth = $birth;
         return $this;
      }
      public function getBirth(){
         return $this->birth;
      }
      
      public function build(){
         return new User($this);
      }
   }
?>