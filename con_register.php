<?php

require('con_db.php');
require('Mail/phpmailer/PHPMailerAutoload.php');



function checkPassword($passwordFunc)
{
    $regex = '/^[a-z0-9!@_-]+$/';
    if (strlen($passwordFunc) < 8) {
        return "Password length must be at least 8 characters";
    }

    if (preg_match($regex, $passwordFunc)) {
        return "";
    } else {
        return "Use only lowercase Latin letters, numerical digits, and the symbols !, -, _,@";
    }
}



session_start();



$username = $_POST['username_register'];
$email = $_POST['email_register'];
$password = $_POST['password_register'];
$confirm_password = $_POST['confirmPassword_register'];


$_SESSION['usernameRegister_unclear'] = $username;
$_SESSION['emailRegister_unclear'] = $email;

if ($_SESSION['captcha'] != $_POST['captcha_register']) {
    header("Location:register_page.php?msg=Incorrect");
    exit();
}

unset($_SESSION['captcha']);

if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    header("Location:register_page.php?msg=Make sure to fill out all the fields");
    exit();
}


$approve = true;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $approve = false;
    $_SESSION['email_error'] = "The email you entered is not valid";
}




$password_approve = checkPassword($password);

if ($password_approve != "") {
    $approve = false;
    $_SESSION['password_error'] = $password_approve;
}


if ($password != $confirm_password) {
    $approve = false;
    $_SESSION['password_match'] = "password doesnt match";
}

//CONNECT TO DABASE VALIDATION ENDS HERE


if ($approve) {
    try {

        $salt =  '$6$' . rand(10000000, 99999999);
        $hashed_password = crypt($password, $salt);

        $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');
        $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ενεργοποίηση λειτουργίας αναφοράς σφαλμάτων PDO

        $sql_select = "SELECT username, email FROM account WHERE username = :username OR email = :email";
        $statement = $pdoObject->prepare($sql_select);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();


        while ($record = $statement->fetch()) {
            if ($record['username'] == $username) {
                header("Location:register_page.php?msg=Τhis username is already in use");
                exit();
            }
            if ($record['email'] == $email) {
                header("Location:register_page.php?msg=This email already exists. Use a different email or try logging in");
                exit();
            }
        }




        $otp = rand(10000, 99999);
        $mail = new PHPMailer;
        $mail->SMTPDebug = 2;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        $mail->Username = 'usedphonesapp@gmail.com';
        $mail->Password = 'vioa mxqz xvbk elvk';

        $mail->setFrom('usedphonesapp@gmail.com', 'OTP Verification');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Your verify code";
        $mail->Body = "<p>Dear $username,</p><p>Your verify OTP code is <b>$otp</b> <br></p>
            <br><br>
            <p>With regards,</p>
            <p>from Us</p>";
        $email_send = $mail->send();

        if (!$email_send) {
            header('Location: register_page.php?msg=Something occured with otp email verification please try again later!');
            exit();
        }

        $sql_insert = "INSERT INTO Account (username, email, password,otp) VALUES (:username, :email, :password, :otp)";

        $statement = $pdoObject->prepare($sql_insert);

        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $statement->bindParam(':otp', $otp, PDO::PARAM_STR);
        $statement->execute();


        $statement->closeCursor();
        $pdoObject = null;

        $_SESSION['username_for_confirmation'] = $username;

        header('Location:verifyEmail_page.php');
    } catch (PDOException $e) {
        header('Location: register_page.php?msg=Something occured with server please try again later!');
        exit();
    }
} else {
    header("Location:register_page.php");
    exit();
}
