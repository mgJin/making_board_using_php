<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Management Page</title>
    <style>
        .container {
            width: 400px;
            
        }
        form{
            width:100%;
            display: flex;
        }
        .wrap-box {
            flex: 1;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            float: left;
            text-align: center;
            cursor: pointer;
        }

        ul {
            list-style: none;
            padding: 0;
            cursor: pointer;
        }

        li {
            margin: 5px 0;
        }
        li:hover{
            background-color: #ddd;
        }

        .btn {
            clear: both;
            text-align: center;
            margin-top: 10px;
        }

        /* Border for <p> tags */
        .wrap-box p {
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php
    global $connect;
    //role name을 가져와서 그에 해당하는 설명과 가지고 있는 permission들을 보여주기
    //role을 추가할 수 있고 그에 맞는 permission들을 지정해서 한 번에 저장가능
    //permissions 들을 여럿 선택할 수 있고 그 선택한 것들이 바로 permission_role table에 저장
    ?>
    <div class="container">
        <form id="rolepermission-form">
            <div class="wrap-box">
                <p>Roles</p>
                <ul class="role-box">
                    <li>Admin</li>
                    <li>Author</li>
                    <li>Logger</li>
                    <li>Child</li>
                </ul>
            </div>
            <div class="wrap-box">
                <p>Permissions</p>
                <ul class="permission-box">
                    <li>canCreateUser<input type="checkbox" name="create-user"></li>
                    <li>canUpdateUser<input type="checkbox" name="update-user"></li>
                    <li>canDeleteUser<input type="checkbox"></li>
                    <li>canCreateBoard<input type="checkbox"></li>
                    <li>canUpdateBoard<input type="checkbox"></li>
                    <li>canDeleteBoard<input type="checkbox"></li>
                    <li>canCreateRole<input type="checkbox"></li>
                    <li>canUpdateRole<input type="checkbox"></li>
                    <li>canDeleteRole<input type="checkbox"></li>
                </ul>
            </div>
        </form>
    </div>
    <div class="btn">
        <button >+</button>
        <button id="upd-btn">update</button>
    </div>
    <script>
        const pb = document.querySelector(".permission-box");
        pb.addEventListener("click",function(event){
            if(event.target.tagName=="LI"){
                let check = event.target.querySelector('input[type="checkbox"]');
                check.checked = !check.checked;
            }
        })
        const updbtn = document.querySelector("#upd-btn");
        updbtn.addEventListener("click",function(){

            // formdata={
            //     ccu:document.querySelector("input[name='create-user']").value,
            //     cuu:document.querySelector("input[name='update-user']").value
            // }
            const fo = document.querySelector("#rolepermission-form");
            let formdata = new FormData(fo);
            postform(formdata);
            
        })

        async function postform(data){
            await fetch("http://localhost:3000/EXP.php",{
                method:"POST",
                body:data
            })
            .then(response=>response.json())
            .then(data=>console.log("성공",data))
            .catch(error=>console.log(error));
           
        }   
        
    </script>
</body>
</html>
        
