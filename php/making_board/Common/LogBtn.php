<script src="../front/js/logInOut.js"></script>
    
    <?php
if ((isset($_SESSION["is_loggedin"]) && $_SESSION["is_loggedin"])) {
    ?>
    <button id="logoutBtn" onclick="logInOutBtn()">로그아웃</button>
    <button id="meBtn" onclick="meBtn()">내 정보</button>
    <?php
} else {
    ?>
    <button onclick="location.href='http:\/\/localhost:3000/loginForm'">로그인</button>
    <?php
}
?>
