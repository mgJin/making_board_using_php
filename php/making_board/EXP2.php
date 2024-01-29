<?php 
        //퍼미션을 가져오는 함수를 만들자 
        function get_all_permissions($user){
            global $connect;
            $role_id = $user["role_id"];
            $sql = "SELECT p.name as permisson FROM permission_role pr JOIN permissions p ON pr.permission_id = p.id WHERE pr.role_id= :role_id";
            $stmt = $connect->prepare($sql);
            $stmt ->bindParam(':role_id',$role_id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
        }
?>