<?php

require('con_db.php');
require('functions.php');
session_start();
$otp = $_POST['verifyEmail'];

if (strlen($otp) < 5) {
    header('Location: verifyEmail_page.php?msg=Invalid verification code. Please enter a 5-digit code');
    exit();
}



try {

    $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');

    $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_select = "SELECT username,otp FROM account  WHERE username = :username AND otp = :otp";

    $statement = $pdoObject->prepare($sql_select);
    $statement->bindParam(':username', $_SESSION['username_for_confirmation'], PDO::PARAM_STR);
    $statement->bindParam(':otp', $otp, PDO::PARAM_STR);
    $statement->execute();


    $record = $statement->fetch();

    if ($record && $record['username'] == $_SESSION['username_for_confirmation'] && $record['otp'] == $otp) {
        
        $sql_update = "UPDATE account SET isVerified = 1 WHERE username = :username";

        $statement = $pdoObject->prepare($sql_update);
        $statement->bindParam(':username', $_SESSION['username_for_confirmation'], PDO::PARAM_STR);

        $statement->execute();


        $statement->closeCursor();
        $pdoObject = null;

        
        session_destroy();
        header("Location:login_page.php");
        exit();
    } else {

        $statement->closeCursor();
        $pdoObject = null;
        header('Location:verifyEmail_page.php?msg=Incorrect verification code. Please try again');
        exit();
    }
} catch (PDOException $e) {
    header('Location: verifyEmail_page.php?msg=Something occured with database please try again later!');
}
