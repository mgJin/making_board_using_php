
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>회원가입</title>
    </head>
    <body>
        <?php 
            $NameMsg = $IDMsg = $PWMsg = $EmailMsg = "" ;
        ?>
        <!--유저 생성 권한만 있는 슈퍼유저가 필요할 듯? -->
    <!--유저 생성 시 id가 unique 인 동시에 not null 이어야할듯-->

    <!--gender 의 datatype :  enum('male','female') -->
    <!--submit누르고 확인버튼 나오는 거랑, 회원가입이 성공하면 /boards 로 이동하게 -->
    <form id="signform" onsubmit="return false">
        ID : <input type = "text" name="id">
        <?php echo $IDMsg;?>
        이름 : <input type = "text" name = "name">
        <?php echo $NameMsg;?>
        PW : <input type = "password" name= "password">
        <?php echo $PWMsg;?>
        Gender : <input type= "radio" name= "gender" value='male'>남자
                 <input type= "radio" name= "gender" value='female'>여자
        birth : <input type = "date" name= "birth">
        <br>
        email : <input type = "text" name="email">
        <?php echo $EmailMsg;?>
        <button id="subbtn">가입</button>
    </form>
    <script>
        
        let sibtn = document.querySelector("#subbtn");
        sibtn.addEventListener("click",function(){
            const pregender =document.querySelector("input[name='gender']:checked");
            const regender = pregender?pregender.value:"";
            const formData = {
            id: document.querySelector("input[name='id']").value,
            name: document.querySelector("input[name='name']").value,
            password: document.querySelector("input[name='password']").value,
            gender: regender,
            birth: document.querySelector("input[name='birth']").value,
            email: document.querySelector("input[name='email']").value
        };
            postJSON(formData);
        })

        async function postJSON(data){
            try{
                const response = await fetch("http://localhost:3000/user",{
                    method: "POST",
                    headers: {
                        "Content-Type":"application/json"
                    },
                    body:JSON.stringify(data)
                });
                const result = await response.json();
                console.log("성공",result);
                const {serverResponse,deninedReason} = result;
                if(serverResponse){
                    alert('가입되었습니다');        
                    window.location.replace("http://localhost:3000/boards");
                }else{
                    alert(deninedReason);
                }
                //이거 자동으로 로그인까지 되게 하던가 아니면 그냥 두던가
                }catch(error){
                console.log("실패",error);
                } 
        }

    </script>
    
</body>
</html>