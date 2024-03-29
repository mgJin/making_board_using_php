<head>
    <link rel='stylesheet' href='/front/css/rolembox.css' type='text/css'>
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
    ?>
    <div class="container">
        <form id="rolepermission-form">
            <div class="wrap-box">
                <div class="p-box">
                    <p>Roles</p>
                </div>
                <ul id="role-box" class="role-ul">
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
                <div class="p-box">
                    <p>Permissions</p>
                </div>
                <ul id="permission-box" class="role-ul">
                    <?php foreach ($permissionArray as $permission) :
                        $temp = explode("-", $permission);
                        $tempArray = [];
                        foreach ($temp as $word) :
                            $tempWord = ucfirst($word);
                            array_push($tempArray, $tempWord);
                        endforeach;
                        $tempString = implode($tempArray);
                    ?>
                        <li><input type="checkbox" name="permissions" id="<?= $permission ?>" value="<?= $permission ?>"><?= "can" . $tempString ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </form>
        <div class="box-btn">

            <button class="btns" id="add-btn">add</button>
            <button class="btns" id="upd-btn">update</button>
            <button class="btns" id="del-btn">delete</button>
        </div>
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
            roleLi.addEventListener("mouseup", function(e) {
                console.log("lili");
                let roleRadio = roleLi.querySelector(".role-radio");
                roleRadio.checked = !roleRadio.checked;
                if (roleRadio.checked) {
                    eventfunction(roleRadio.value);
                } else {
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
                    newli.addEventListener("mousedown", function(e) {
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
            await fetch("<?= BASE_URL ?>/adminpage/rolemanagement", {
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
            fetch("<?= BASE_URL ?>/adminpage/rolemanagement", {
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
            await fetch("<?= BASE_URL ?>/adminpage/rolemanagement", {
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
            await fetch("<?= BASE_URL ?>/adminpage/rolemanagement/event", {
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