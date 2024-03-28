<?php
        global $connect;
        $result = [];
        $titleMsg = "";
        //입력검증
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $rawData = file_get_contents("php://input");
            $data = json_decode($rawData);

            $dbconnect= true;
            if(!$data->title){
                $titleMsg = "제목을 입력해주세요";
                $dbconnect = false;
            }else{
                $title = $data->title;
            }
            $text = $data->text;
            if($dbconnect){
                
                $writer = $_SESSION["user"]["user_id"];
                $date = date("Y-m-d");
                
                try{
                    
                    $sql = 
                    "INSERT INTO board
                        set title = '$title',
                            text = '$text',
                            created = '$date',
                            writer = '$writer'
                    ";
                    $stmt = $connect->prepare($sql);
                    $exec = $stmt->execute();
                    if($exec){
                        $lastInsert = $connect->lastInsertId();
                        $sql = "SELECT id FROM board WHERE id=$lastInsert";
                        $mresult = $connect->query($sql);
                        if($mresult->rowCount()>0){
                            $lastBoardID = $mresult->fetch(PDO::FETCH_ASSOC);
                            $result = ["serverResponse"=>true,"boardID"=>$lastBoardID["id"]];
                        }
                    }
                    
                }catch(PDOException $ex){
                    $result =["serverResponse="=>false,"deninedReason"=>$ex->getMessage()];
                }catch(Exception $ex){
                    $result=["serverResponse="=>false,"deninedReason"=>$ex->getMessage()];
                }
                header('Content-Type:application/json');
                echo jsonMaker($result);
            }
            
        }
?>