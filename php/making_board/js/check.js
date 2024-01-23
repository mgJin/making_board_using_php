const button_upd = document.querySelector("#upd");
const button_del = document.querySelector("#del");
const btn = document.querySelectorAll(".btn");
//js 로 컨펌만 하고 다시 php 로 보낸다. 그 후 php 에서 해당 유저가 권한이 있는지 확인 후 진행 
for(let i=0; i<btn.length;i++){
    btn[i].addEventListener("click",crd);

}
//업데이트 따로 삭제따로 function 나눈 다음 분기태우기
//value 보내는거 고민좀 해봐야할듯
function upd(event){
    // console.log(event);
    // console.log(event.target);
    // if(event.target.value=="delete"){
    //     console.log("삭제삭제");
    //     // var chk = confirm("삭제하시겠습니까?");
    //     // if(chk){
    //     //     var php = "delete.php";
    //     //     location = php;
    //     // }
    // }else if(event.target.value=="update"){
    //     console.log("수정수정");
    // }
    console.log(btn);
    
}
function crd(event){
    console.log(event);
    console.log(event.target.value);
}

// function exp(event){
//     console.log(event);
// // }
// button_upd.addEventListener("click",upd);
// cle.addEventListener("click",exp);


