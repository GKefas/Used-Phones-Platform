<!DOCTYPE html>
<html>

<head>
    <?php require('headPart.php') ?>
</head>

<body>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <div class="main_container" id="resize_login">

        <?php require('navbar.php') ?>
        <?php require('functions.php') ?>
        <div class="login_container">
            <div class="form_wrap">
                <form method="post" action="con_login.php">
                    <div id="inputs_container">
                        <?php
                        if (isset($_GET['msg']) && $_GET['msg'] != 'Incorrect') {
                            echo '<div class="errors loginError">' . filterized_msg($_GET['msg']) . '</div>';
                        }
                        ?>
                        <label style="margin-bottom:10px;" for="Username">Username:<br></label>
                        <input type="text" name="username_login" id="Username" value=<?php
                                                                                        if (isset($_SESSION['username_unclear'])) {
                                                                                            echo '"' . $_SESSION['username_unclear'] . '"';
                                                                                        } else {
                                                                                            echo '""';
                                                                                        }
                                                                                        unset($_SESSION['unsername_unclear']);
                                                                                        ?> /><br>
                        <label style="margin-bottom:10px;" for="password" style="margin-top:35px;">Password:<br></label>
                        <input type="password" name="password_login" id="password" /><br>
                        <label style="margin-bottom:10px;" for="cptcha" style="margin-top:35px;">Captcha</label>
                        <div id="cptchaNumbers">
                            <?php
                            $captcha_value = rand(10000, 99999);
                            $_SESSION['captcha'] = $captcha_value;
                            echo $captcha_value; ?>
                        </div>
                        <input type="text" name="captcha_login" id="cptcha" maxlength=5 style="margin-top:15px" />
                        <?php
                        if (isset($_GET['msg']) && $_GET['msg'] == "Incorrect") {
                            echo '<div class="errors" id="captcha_error">' . filterized_msg($_GET['msg']) . '</div>';
                        }
                        ?>
                    </div>
                    <div id="buttons_container">
                        <a href="register_page.php"><input type="button" name="RegisterButton" id="RegisterButton" value="Sign Up" class="secondary_btn" /></a>
                        <input type="submit" name="submitlogin" id="SubmitButton" class="primary_btn" value="Login">
                    </div>
                </form>
            </div>
        </div>

        <?php require('footer.php') ?>
    </div>
</body>

</html>