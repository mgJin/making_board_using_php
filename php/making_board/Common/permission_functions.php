<?php 
        //역할에 따른 퍼미션을 가져오는 함수(fetch_column으로 1차원배열을 가져옴)
        function getRolesPermissions($connect,$role_id){
            
            $sql = "SELECT p.name as permissionName FROM permission_role pr JOIN permissions p ON pr.permission_id = p.id WHERE pr.role_id= :role_id";
            $stmt = $connect->prepare($sql);
            $stmt ->bindParam(':role_id',$role_id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            return $result;
        }

        
        // role_id 를 가져오는 함수
        function getRoleId($connect,$user_id){

            $sql = "SELECT role_id FROM member WHERE user_id = :user_id LIMIT 1";
            $stmt = $connect->prepare($sql);
            
            $stmt->bindParam(':user_id',$user_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
            
        }
        //해당 게시글의 writer를 가져오는 함수
        function getWriter($connect,$boardID){
            $sql = "SELECT m.user_id FROM board b JOIN member m on b.writer = m.user_id where b.id=:boardID";
            $stmt=$connect->prepare($sql);
            $stmt->bindParam(':boardID',$boardID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
        }
        

        //게시물 생성 권한 확인
        function canCreateBoard($permissionsArray){
            if(in_array('create-board',$permissionsArray)){
                return true;
            }else{
                return false;
            }
        }
        //게시물 수정 권한 확인
        //여기다가 arg 로 boardid 랑 userid를 넣으면 될듯
        //boardid 는 middleware에서 url에서 받아오는 식으로하자
        function canUpdateBoard($permissionsArray,$boardID,$user_id,$connect){
            if(!in_array('update-board',$permissionsArray)){
                return false;
            }
            //기본 골자select * from board b join member m on b.writer = m.user_id where b.id=8;
            //select할 때 user id를 받은 후 
            //아니다 sql에서 바로 찾을 수 있게 where 절에 user_id가 일치하는지 까지 넣어서 해보자
            $result = getWriter($connect,$boardID);
            if(!$result){
                return false;
            }
            if($result===$user_id){
                return true;
            }else{
                return false;
            }
        }

        //게시물 삭제권한 확인
        function canDeleteBoard($permissionsArray,$boardID,$user_id,$connect){
            if(!in_array('delete-board',$permissionsArray)){
                return false;
            }
            $result = getWriter($connect,$boardID);
            if(!$result){
                return false;
            }
            if($result===$user_id){
                return true;
            }else{
                return false;
            }
        }
        //유저 생성 권한 확인
        function canCreateUser($permissionsArray){
            if(in_array('create-user',$permissionsArray)){
                return true;
            }else{
                return false;
            }
        }
        //유저 수정 권한 확인
        function canUpdateUser($permissionsArray){
            if(in_array('update-user',$permissionsArray)){
                return true;
            }else{
                return false;
            }
        }
        //유저 삭제 권한 확인
        function canDeleteUser($permissionsArray){
            if(in_array('delete-user',$permissionsArray)){
                return true;
            }else{
                return false;
            }
        }
?>