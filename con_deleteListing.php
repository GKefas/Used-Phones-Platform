<?php
require('con_db.php');
session_start();
try {
    $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ενεργοποίηση λειτουργίας αναφοράς σφαλμάτων PDO


    $sql_delete = "DELETE FROM phone WHERE Account_username = :username";
    $statement = $pdoObject->prepare($sql_delete);
    $statement->bindValue(':username', $_SESSION['username'], PDO::PARAM_STR);
    $statement->execute();


    $statement->closeCursor();
    $pdoObject = null;
    header("Location: platform.php");
    exit();
} catch (PDOException $e) {
    header('Location:platform.php');
    exit();
}
