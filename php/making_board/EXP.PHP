/*click role event (각 role-radio 누를 때의 이벤트)*/
        // const roleRadios = document.querySelectorAll(".role-radio");
        // roleRadios.forEach(function(roleRadio) {
        //     roleRadio.addEventListener("change", async function(e) {
        //         const fetchData = {
        //             role_name: e.target.value
        //         };
        //         await fetch("http://localhost:3000/adminpage/rolemanagement/event", {
        //                 method: "POST",
        //                 body: JSON.stringify(fetchData)
        //             })
        //             .then(response => response.json())
        //             .then(data => {

        //                 const checkboxs = document.querySelectorAll("input[type='checkbox']");
        //                 checkboxs.forEach(function(checkbox) {
        //                     checkbox.checked = false;
        //                 })

        //                 for (let permission1 in data) {

        //                     let willCheckedBox = document.getElementById(data[permission1]);
        //                     willCheckedBox.checked = true;
        //                 }
        //             })
        //             .catch(error => console.log("실패", error));
        //     })
        // })
