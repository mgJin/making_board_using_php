<?php
        
        $result = [];
        $titleMsg = "";
        //입력검증
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $dbconnect= true;
            if(!$_POST["title"]){
                $titleMsg = "제목을 입력해주세요";
                $dbconnect = false;
            }else{
                $title = $_POST["title"];
            }
            $text = $_POST["text"];
            if($dbconnect){
                $writer = $_SESSION["user"]["user_id"];
                $date = date("Y-m-d");
                $servername = "localhost";
                $dbuser = "root";//퍼블릭 유저로 바꾸기
                $password = "9094";
                $dbname = "phpboard";
                try{
                    $mysqliconnect = mysqli_connect($servername,$dbuser,$password,$dbname);
                    $sql = 
                    "INSERT INTO board
                        set title = '$title',
                            text = '$text',
                            created = '$date',
                            writer = '$writer'
                    ";
                    $stmt = mysqli_prepare($mysqliconnect,$sql);
                    $exec = mysqli_stmt_execute($stmt);
                    if($exec){
                        $lastInsert = $mysqliconnect->insert_id;
                        $sql = "SELECT id FROM board WHERE id=$lastInsert";
                        $mresult = $mysqliconnect->query($sql);
                        if($mresult->num_rows>0){
                            $lastBoardID = $mresult->fetch_assoc();
                            $result = ["serverResponse"=>true,"boardID"=>$lastBoardID["id"]];
                        }
                    }
                    
                }catch(mysqli_sql_exception $ex){
                    $result =["serverResponse="=>false,"deninedReason"=>$ex->getMessage()];
                }catch(Exception $ex){
                    $result=["serverResponse="=>false,"deninedReason"=>$ex->getMessage()];
                }
                header('Content-Type: application/json');
                echo jsonMaker($result);
            }
            
        }
?>