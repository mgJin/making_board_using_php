<?php 
    if(!(isset($_SESSION["is_loggedin"])&&$_SESSION["is_loggedin"])):?>
        <button id="signUpBtn" onclick="location.href='http:\/\/localhost:3000\/userSignup'">회원가입</button>
    <?php endif;?>