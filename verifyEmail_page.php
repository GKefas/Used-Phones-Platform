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
                <form method="post" action="con_verifyEmail.php">
                    <div id="verification_container">
                        <?php
                        if (isset($_GET['msg'])) {
                            echo '<div class="errors loginError">' . filterized_msg($_GET['msg']) . '</div>';
                        }
                        ?>
                        <div id="headerForVerify">A verification code has been sent to your email address!</div>
                        <div id="inputs">
                            <label for="verifyEmail" style="margin-bottom:10px;" id="labelVerifyEmail">Enter verification code:</label>
                            <input type="text" name="verifyEmail" id="verifyEmail" maxlength="5">
                        </div>
                        <input type="submit" name="verifyEmailButton" value="Confirm" class="primary_btn">
                    </div>
                    <p id="info"><strong>After signing up, you must login to access your account <i class="fa-solid fa-triangle-exclamation"></i></strong></p>

                </form>
            </div>
        </div>

        <?php require('footer.php') ?>
    </div>
</body>

</html>