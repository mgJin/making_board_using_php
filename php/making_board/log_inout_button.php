<?php
if ((isset($_SESSION["is_loggedin"]) && $_SESSION["is_loggedin"])) {
    ?>
    <button onclick="location.href='logout.php'">로그아웃</button>
<?php
} else {
    ?>
    <button onclick="location.href='login.php'">로그인</button>
<?php
}
?>