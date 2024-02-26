<!DOCTYPE html>
<html>

<head>
    <?php require('headPart.php') ?>
</head>

<body>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <div class="main_container">

        <?php require('navbar.php') ?>
        <?php require('functions.php') ?>
        <div class="login_container" id="registerContainer">
            <div class="form_wrap">
                <form method="post" action="con_register.php">

                    <div id="inputs_container">
                        <?php
                        if (isset($_GET['msg']) && $_GET['msg'] != 'Incorrect') {
                            echo '<div class="errors loginError">' . filterized_msg($_GET['msg']) . '</div>';
                        }
                        ?>
                        <label style="margin-bottom:10px;" for="Username">Username:<br></label>

                        <input type="text" name="username_register" id="Username" value=<?php
                                                                                        if (isset($_SESSION['usernameRegister_unclear'])) {
                                                                                            echo '"' . $_SESSION['usernameRegister_unclear'] . '"';
                                                                                        } else {
                                                                                            echo '""';
                                                                                        }
                                                                                        unset($_SESSION['usernameRegister_unclear']);
                                                                                        ?> />
                        <div class="errors registerLabelError"></div>
                        <label style="margin:15px 0; " for="email" style="margin-top:35px;">Email:<br></label>
                        <input type="text" name="email_register" id="email" value=<?php
                                                                                    if (isset($_SESSION['emailRegister_unclear'])) {
                                                                                        echo '"' . $_SESSION['emailRegister_unclear'] . '"';
                                                                                    } else {
                                                                                        echo '""';
                                                                                    }
                                                                                    unset($_SESSION['emailRegister_unclear']);
                                                                                    ?> />
                        <div class="errors registerLabelError" id="emailErrorDisplay"><?php if (!empty($_SESSION['email_error'])) {
                                                                                            echo filterized_msg($_SESSION['email_error']);
                                                                                            unset($_SESSION['email_error']);
                                                                                        } ?></div>
                        <label style="margin:15px 0;" for="password" style="margin-top:35px;">Password:<br></label>
                        <input type="password" name="password_register" id="password" />
                        <div class="errors registerLabelError" id="passwordErrorDisplay"><?php if (!empty($_SESSION['password_error'])) {
                                                                                                echo filterized_msg($_SESSION['password_error']);
                                                                                                unset($_SESSION['password_error']);
                                                                                            }
                                                                                            
                                                                                            ?></div>
                        <label style="margin:15px 0;;" for="confirmPassword" style="margin-top:35px;">Confirm Password:<br></label>
                        <input type="password" name="confirmPassword_register" id="confirmPassword" />
                        <div class="errors registerLabelError" id="confirmPasswordError"><?php if (!empty($_SESSION['password_match'])) {
                                                                                                echo filterized_msg($_SESSION['password_match']);
                                                                                                unset($_SESSION['password_match']);
                                                                                            } ?></div>

                        <label style="margin:15px 0;" for="cptcha" style="padding-top:55px;">Captcha</label>
                        <div id="cptchaNumbers">
                            <?php
                            $captcha_value = rand(10000, 99999);
                            $_SESSION['captcha'] = $captcha_value;
                            echo $captcha_value; ?>
                        </div>
                        <input type="text" name="captcha_register" id="cptcha" maxlength=5 />
                        <?php if (isset($_GET['msg']) && $_GET['msg'] == "Incorrect") {
                            echo '<div class="errors" id="captcha_error">' . filterized_msg($_GET['msg']) . '</div>';
                        }
                        ?>
                    </div>
                    <div id="exist">
                        Do u already have an account?<br>Login <a href="login_page.php">Here!</a>
                    </div>
                    <div id="single_button">
                        <input type="submit" name="submitRegister" id="RegisterButton" class="primary_btn" value="Sign up">
                    </div>
                </form>
            </div>
        </div>

        <?php require('footer.php') ?>
    </div>
    <script type="text/javascript" src="scripts/registerValidator.js"> </script>
</body>

</html>