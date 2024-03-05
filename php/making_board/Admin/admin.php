<!-- admin page-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>관리자 페이지</title>
    <style>
        section{
            padding:10px;
        }
        aside{
            padding:10px;
            width:20%;
            float:left;
        }
        article{
            padding:10px;
            width:70%;
            float:left;
        }
        li{
            list-style: none;
            padding : 10px;
            border : 1px solid #ddd;
            cursor : pointer;
        }
        li:hover{
            background-color: #f0f0f0;
        }
        /**managements와 active의 순서 유의 */
        .managements{
            display:none;
        }
        .active{
            display:block;
        }
        a.infoA{
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <?php 
        global $connect;
        $sql = "SELECT user_pk,user_id,role_id FROM member";
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $userArrays = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $sql = "SELECT id,title,writer FROM board";
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $boardArrays = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <section>
        <aside>
            <ul class="managementList">
                <li class="asideLI" onclick="onShow('Base')">Base</li>
                <li class="asideLI" onclick="onShow('UserManagement')">UserManagement</li>
                <li class="asideLI" onclick="onShow('BoardManagement')">Board management</li>
            </ul>
        </aside>
        <article>
            <div id="Base"class="managements">Welcome Admin Page</div>
            <div id="UserManagement" class="managements">
                <nav>
                    <ul>    
                        <?php foreach($userArrays as $userInfo){?>
                            <li>
                                <a class="infoA" <?php echo "href='http://localhost:3000/adminpage/userinfo/".$userInfo['user_pk']."'";?>>
                                    <?php echo $userInfo["user_id"]?>
                                </a>
                            </li>
                        <?php }; ?>
                    </ul>
                </nav>
            </div>
            <div id="BoardManagement" class="managements">
                <nav>
                    <ul>    
                        <?php foreach($boardArrays as $boardInfo){?>
                            <li>
                                <a class="infoA" href="">
                                    <?php echo $boardInfo["title"]?>
                                </a>
                            </li>
                        <?php }; ?>
                    </ul>
                </nav>
            </div>
        </article>
    </section>
    <?php ?>
    <script>
        document.addEventListener('DOMContentLoaded',function(){
            let lastIndex = localStorage.getItem('lastShowContentIndex');
            if(lastIndex!==null){
                let Managements = document.querySelectorAll(".managements");
                if(Managements[lastIndex]){
                    Managements[lastIndex].classList.add('active');
                }
            }
            let lis = document.querySelectorAll(".asideLI");
            lis.forEach(function(element,index){
                element.addEventListener("click",function(){
                    localStorage.setItem('lastShowContentIndex',index);
                })
            })
        })

        function onShow(selected){
            const managements = document.querySelectorAll(".managements");
            for (var i =0;i<managements.length;i++){
                managements[i].classList.remove('active');
            }
            const management = document.getElementById(selected);
            management.classList.add('active');
        }
    </script>
</body>
</html>
    