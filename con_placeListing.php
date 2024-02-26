<?php
require('con_db.php');
session_start();
function validator()
{
    $approve = false;
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $color = $_POST['color'];
    $ramSize = $_POST['ramSize'];
    $cores = $_POST['cores'];
    $storageSize = $_POST['storageSize'];
    $osVersion = $_POST['osVersion'];
    $price = $_POST['price'];
    $descreption = $_POST['descreption'];

    $onlyLettersRegex = '/^[a-zA-Z\s][a-zA-Z\s]+$/';
    $onlyNumbersRegex = '/^[0-9]+$/';
    $numberAndLettersRegex = '/^[a-zA-Z0-9][a-zA-Z0-9\s]+$/';

    if (preg_match($onlyLettersRegex, $brand) && preg_match($onlyLettersRegex, $color)) {
        $approve = true;
    }

    if (preg_match($numberAndLettersRegex, $model) && preg_match($numberAndLettersRegex, $osVersion)) {
        $approve = true;
    } else {
        $approve = false;
    }
    if (
        preg_match($onlyNumbersRegex, $ramSize) && preg_match($onlyNumbersRegex, $cores)
        && preg_match($onlyNumbersRegex, $storageSize) && preg_match($onlyNumbersRegex, $price)
    ) {
        $approve = true;
    } else {
        $approve = false;
    }



    if ($_FILES['imageUpload']['size'] <= 400 * 1024 && $_FILES['imageUpload']['size'] > 0) {
        $approve = true;
    } else {
        $approve = false;
    }

    if ($_FILES['imageUpload']['type'] == 'image/jpeg' || $_FILES['imageUpload']['type'] == 'image/jpg') {
        $approve = true;
    } else {
        $approve = false;
    }

    return $approve;
}

$approve = false;


$approved = validator();

if ($approved) {

    try {

        $brand = $_POST['brand'];
        $model = $_POST['model'];
        $color = $_POST['color'];
        $ramSize = $_POST['ramSize'];
        $cores = $_POST['cores'];
        $storageSize = $_POST['storageSize'];
        $osVersion = $_POST['osVersion'];
        $price = $_POST['price'];
        $description = $_POST['descreption'];
        $image = file_get_contents($_FILES['imageUpload']['tmp_name']);
        $date = $_POST['releaseDate'];
        $formatted_date = date('Y-m-d', strtotime($date));

        $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');
        $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ενεργοποίηση λειτουργίας αναφοράς σφαλμάτων PDO

        $sql_insert = 'INSERT INTO PHONE (brand,model,color,ramSize,cores,storageSize,osVersion,releaseDate,price,description,image,Account_username) 
                VALUES (:brand,:model,:color,:ramSize,:cores,:storageSize,:osVersion,:date,
                        :price,:description,:image,:username)';


        $statement = $pdoObject->prepare($sql_insert);

        $statement->bindParam(':brand', $brand);
        $statement->bindParam(':model', $model);
        $statement->bindParam(':color', $color);
        $statement->bindParam(':ramSize', $ramSize);
        $statement->bindParam(':cores', $cores);
        $statement->bindParam(':storageSize', $storageSize);
        $statement->bindParam(':osVersion', $osVersion);
        $statement->bindParam(':price', $price);
        $statement->bindParam(':description', $description);
        $statement->bindParam(':date', $formatted_date);
        $statement->bindParam(':image', $image, PDO::PARAM_LOB);
        $statement->bindParam(':username', $_SESSION['username']);

        $statement->execute();


        $statement->closeCursor();
        $pdoObject = null;

        header('Location:platform.php');
        exit();
    } catch (PDOException $e) {
        header("Location:placeListing.php?msg=Something occured with server please try again later!");
    }
} else {
    header("Location:placeListing.php?msg=Oops! It seems there's a mistake with the provided details. Please review and try again.");
    exit();
}
