<head>
    <style>
        .container {
            width: 400px;

        }

        form {
            width: 100%;
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

        li:hover {
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
    $sql = "SELECT name FROM roles";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $roleArray = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $sql = "SELECT name FROM permissions ORDER BY id";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $permissionArray = $stmt->fetchAll(PDO::FETCH_COLUMN);
    //role name을 가져와서 그에 해당하는 설명과 가지고 있는 permission들을 보여주기
    //role을 추가할 수 있고 그에 맞는 permission들을 지정해서 한 번에 저장가능
    //permissions 들을 여럿 선택할 수 있고 그 선택한 것들이 바로 permission_role table에 저장
    ?>
    <div class="container">
        <form id="rolepermission-form">
            <div class="wrap-box">
                <p>Roles</p>
                <ul id="role-box">
                    <?php foreach ($roleArray as $role) : ?>
                        <li class="role-li">
                            <label>
                                <input class="role-radio" type="radio" name="role" value="<?= $role ?>"> <?= $role ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button id="addList-btn">+</button>
            </div>
            <div class="wrap-box">
                <p>Permissions</p>
                <ul id="permission-box">
                    <?php foreach ($permissionArray as $permission) :
                        $temp = explode("-", $permission);
                        $tempArray = [];
                        foreach ($temp as $word) :
                            $tempWord = ucfirst($word);
                            array_push($tempArray, $tempWord);
                        endforeach;
                        $tempString = implode($tempArray);
                    ?>
                        <li><?= "can" . $tempString ?><input type="checkbox" name="permissions" id="<?= $permission ?>" value="<?= $permission ?>"></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </form>
    </div>
    <div class="btn">

        <button id="add-btn">add</button>
        <button id="upd-btn">update</button>
        <button id="del-btn">delete</button>
    </div>
    <script>
        /*check box event (permission누를 때 checkbox도 되는것*/
        const pb = document.querySelector("#permission-box");
        pb.addEventListener("click", function(event) {
            if (event.target.tagName == "LI") {
                let check = event.target.querySelector('input[type="checkbox"]');
                check.checked = !check.checked;
            }
        })
        /**click role hover event(각 role radio의 빈공간을 누를 때의 이벤트) */
        const roleLis = document.querySelectorAll(".role-li");
        roleLis.forEach(function(roleLi) {
            roleLi.addEventListener("mousedown", function(e) {
                let roleRadio = roleLi.querySelector(".role-radio");
                roleRadio.checked = !roleRadio.checked;
                if (roleRadio.checked) {
                    eventfunction(roleRadio.value);
                }else{
                    const checkboxs = document.querySelectorAll("input[type='checkbox']");
                    checkboxs.forEach(function(checkbox) {
                        checkbox.checked = false;
                    })
                }
            })
        })
        /*add role-list event (+누를 때의 이벤트)*/
        const addListbtn = document.querySelector("#addList-btn");
        addListbtn.addEventListener("click", function(e) {
            e.preventDefault();

            if (e.pointerId < 0) {
                return;
            }
            const newinputtext = document.createElement("input");
            newinputtext.setAttribute("type", "text");
            newinputtext.classList.add("temptext");
            const newlabel = document.createElement("label");
            const newli = document.createElement("li");
            newli.classList.add("role-li");
            // newlabel.appendChild(newinput);
            newlabel.appendChild(newinputtext);
            newli.appendChild(newlabel);
            const ulbox = document.querySelector("#role-box");
            ulbox.appendChild(newli);
            newinputtext.addEventListener("keyup", function(event) {
                if (event.key === "Enter") {

                    event.preventDefault();
                    const newinputradio = document.createElement("input");
                    newinputradio.setAttribute("type", "radio");
                    newinputradio.setAttribute("name", "role");
                    newinputradio.classList.add("role-radio");
                    newinputradio.setAttribute("value", event.target.value);
                    newlabel.appendChild(newinputradio);
                    newlabel.appendChild(document.createTextNode(event.target.value));
                    newinputtext.remove();
                    newli.addEventListener("mousedown",function(e){
                        let roleRadio = newli.querySelector(".role-radio");
                        roleRadio.checked = !roleRadio.checked;
                
            })
                }
            })
            
            // }

        })
        
        
        /*add role event*/
        const addbtn = document.querySelector("#add-btn");
        addbtn.addEventListener("click", function() {
            const fo = document.querySelector("#rolepermission-form");
            let formdata = new FormData(fo);
            let permissioncheckboxs = document.querySelectorAll("input[name='permissions']");

            let pmvalues = Array.from(permissioncheckboxs,
                (chk) => {
                    if (chk.checked) {
                        return chk;
                    } else {
                        return null;
                    }
                }
            ).filter(
                (chk) => {
                    if (chk) {
                        return chk;
                    }
                }
            ).map(
                (chk) => {
                    return chk.value;
                }
            )
            if (pmvalues.length > 0) {
                formdata.set('permissionsArray', pmvalues);
            };

            postform(formdata);

        })
        /*update role event*/
        const updbtn = document.querySelector("#upd-btn");
        updbtn.addEventListener("click", async function(e) {
            const roles = document.querySelectorAll("input[name='role']");
            let chkRole = null;
            for (let i = 0; i < roles.length; i++) {
                if (roles[i].checked) {
                    chkRole = roles[i].value;
                    break;
                }
            }
            let permissioncheckboxs = document.querySelectorAll("input[name='permissions']");
            let pmvalues = Array.from(permissioncheckboxs,
                (chk) => {
                    if (chk.checked) {
                        return chk;
                    } else {
                        return null;
                    }
                }
            ).filter(
                (chk) => {
                    if (chk) {
                        return chk;
                    }
                }
            ).map(
                (chk) => {
                    return chk.value;
                }
            )
            const formData = {
                role: chkRole,
                permissionsValues: pmvalues
            }
            await fetch("http://localhost:3000/adminpage/rolemanagement", {
                    method: "PUT",
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then((data) => {
                    console.log("성공", data);
                    const {
                        serverResponse,
                        deniedReason
                    } = data;
                    if (serverResponse) {
                        // location.reload(true);
                    } else {
                        alert(deniedReason);
                    }
                })
                .catch((error) => console.log("실패", error));

        })
        /*delete role event*/
        const delbtn = document.querySelector("#del-btn");
        delbtn.addEventListener("click", function(e) {
            const roles = document.querySelectorAll("input[name='role']");
            let chkRole = null;
            for (let i = 0; i < roles.length; i++) {
                if (roles[i].checked) {
                    chkRole = roles[i].value;
                    break;
                }
            }
            const fetchData = {
                checkedRole: chkRole
            };
            fetch("http://localhost:3000/adminpage/rolemanagement", {
                    method: "DELETE",
                    body: JSON.stringify(fetchData)
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log("성공", data);
                    const {
                        serverResponse
                    } = data;
                    if (serverResponse) {
                        location.reload(true);
                    }
                })
                .catch(error => console.log("실패", error));
        })

        async function postform(data) {
            await fetch("http://localhost:3000/adminpage/rolemanagement", {
                    method: "POST",
                    body: data
                })
                .then(response => response.json())
                .then(data => {
                    console.log("성공", data);
                    const {
                        serverResponse,
                        deniedReason
                    } = data;
                    if (serverResponse === false) {
                        alert(deniedReason);
                    }
                }) //여기다가 추가로 성공 시 새로고침을 넣던가
                .catch(error => console.log(error));

        }
        /** 하버 클릭했을때 role에 해당하는 permission 들이 자동선택 */
        const eventfunction = async (value) => {
            const fetchData = {
                role_name: value
            };
            await fetch("http://localhost:3000/adminpage/rolemanagement/event", {
                    method: "POST",
                    body: JSON.stringify(fetchData)
                })
                .then(response => response.json())
                .then(data => {

                    const checkboxs = document.querySelectorAll("input[type='checkbox']");
                    checkboxs.forEach(function(checkbox) {
                        checkbox.checked = false;
                    })

                    for (let permission1 in data) {

                        let willCheckedBox = document.getElementById(data[permission1]);
                        willCheckedBox.checked = true;
                    }
                })
                .catch(error => console.log("실패", error));
        }
    </script>
</body>