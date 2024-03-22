
<!--세션에 is_login 이 묶여있다면 로그아웃 버튼 보이게 -->
<!--서버를 스탑했다가 다시 시작할 때 로그인이 유지가 되는 문제 -->
<?php


if ((isset($_SESSION["is_loggedin"]) && $_SESSION["is_loggedin"])){
    header("Location:".BASE_URL."/boards");
}    
//로그인을 요청하면 userid와 userpw 를 입력했는지 확인 후 db에 select로 확인


?>
<style>
    .login-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 300px;
    }
    .login-container h2 {
        text-align: center;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
    }
    .form-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .btn-login {
        width: 100%;
        padding: 10px;
        background-color: coral;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .btn-login:hover {
        background-color: #FFAB91;
    }
</style>
<form action = "<?= BASE_URL?>/loginForm" method = "POST">
        <div class="form-group">
            <label for="userid">Userid:</label>
            <input type="text" id="userid" name="userid" placeholder="Enter your userid">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="userpw" placeholder="Enter your password">
        </div>
        <button type="submit" class="btn-login">Login</button>
    </form>

