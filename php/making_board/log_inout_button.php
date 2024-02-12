    <?php
if ((isset($_SESSION["is_loggedin"]) && $_SESSION["is_loggedin"])) {
    ?>
    <button id="logoutBtn">로그아웃</button>
    <?php
} else {
    ?>
    <button onclick="location.href='http:\/\/localhost:3000/login'">로그인</button>
    <?php
}
?>
