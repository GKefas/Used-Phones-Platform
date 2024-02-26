<?php

require('con_db.php');
require('functions.php');

session_start();

$username = $_POST['username_login'];


if ($_SESSION['captcha'] != $_POST['captcha_login']) {

    $_SESSION['username_unclear'] = $username;
    header("Location:login_page.php?msg=Incorrect");
    exit();
}

unset($_SESSION['captcha']);


try {
    $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ενεργοποίηση λειτουργίας αναφοράς σφαλμάτων PDO
    $pdoObject->exec('set names utf8');

    $password = $_POST['password_login'];


    $sql = 'SELECT username,password,isVerified FROM account WHERE username = :username';
    $statement = $pdoObject->prepare($sql);

    $statement->bindParam(':username', $username, PDO::PARAM_STR);

    $statement->execute();




    $approve = false;

    while ($record = $statement->fetch()) {
        if ($record['username'] == $username &&  crypt($password, $record['password']) === $record['password']) {


            if ($record['isVerified'] != 1) {
                header('Location:verifyEmail_page.php');
                exit();
            }
            $approve = true;
        }
    }

    if ($approve) {
        $_SESSION['username'] = $username;
        header("Location:platform.php");
        exit();
    } else {
        $_SESSION['username_unclear'] = $username;
        header("Location:login_page.php?msg=Incorrect username or password");
        exit();
    }

    $statement->closeCursor();
    $pdoObject = null;
} catch (PDOException $e) {
    header('Location: login_page.php?msg=Something occured with server please try again later!');
    exit();
}
