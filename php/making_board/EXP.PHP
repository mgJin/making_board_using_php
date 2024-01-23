<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        if(array_key_exists("update",$_POST)){
            $beh = "update";
            echo chkbutton($beh,$_POST["$beh"]);
        }else if(array_key_exists("delete",$_POST)){
            $beh = "delete";
            echo chkbutton($beh,$_POST["$beh"]);
        }
        function chkbutton(string $beh,string $hangul){
    
            $ev = "var chk= confirm('$hangul 하시겠습니까?');
                   if(chk){
                    var php = '$beh'+'_board.php';
                    location = php;}"
                    ;
            return "<script>$ev</script>";
        }
    ?>
    <form method="post">
        <input type="submit" name = "update" value = "수정">
        <input type="submit" name = "delete" value = "삭제">
    </form>
    
    <!-- <script src="/js/check.js"></script> -->
</body>
</html>