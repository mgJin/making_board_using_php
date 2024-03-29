

<!--gender 의 datatype :  enum('male','female') -->
<!--submit누르고 확인버튼 나오는 거랑, 회원가입이 성공하면 /boards 로 이동하게 -->
<link rel="stylesheet" href='/front/css/formdesign.css' type='text/css'>
<link rel='stylesheet' href='/front/css/formdesign_radio.css' type='text/css'>
<form class="form-container" id="signform" onsubmit="return false">
    <div class="form-group">
        <label for="id">ID</label>
        <input type = "text" name="id">
    </div>
    <div class="form-group">
        <label for="name">이름</label>
        <input type = "text" name = "name">
    </div>
    <div class="form-group">
        <label for="password">PassWord</label>
        <input type = "password" name= "password">
    </div>
    <div class="form-group1">
        <label class="radio-label">성별</label>
        <div class="radio-container">

            <div class="radio-box">
                <p class="radio-content1">남성</p>
                <input type= "radio" class="radio-content" name= "gender" value='male'>
            </div>
            
            <div class="radio-box">
                <p class="radio-content2">여성</p>    
                <input type= "radio" class="radio-content" name= "gender" value='female'>
            </div>
        </div>
        
    </div>
    <div class="form-group">
        <label for="birth">생일</label>
        <input type = "date" name= "birth">
    </div>
    <div class="form-group">
        <label for="email">이메일</label>
        <input type = "text" name="email">
    </div>
    <div class="btn-container">
        <button class="submit-btn" id="subbtn">가입</button>
    </div>
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
            const response = await fetch("<?= BASE_URL?>/signupform",{
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
                window.location.replace("<?= BASE_URL?>/boards");
            }else{
                alert(deninedReason);
            }
            // //이거 자동으로 로그인까지 되게 하던가 아니면 그냥 두던가
            }catch(error){
            console.log("실패",error);
            } 
    }

</script>
