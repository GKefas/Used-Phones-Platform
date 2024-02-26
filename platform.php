<?php
require('con_db.php');

$phones = [];
try {
    $mode = '';
    $phones = [];
    $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ενεργοποίηση λειτουργίας αναφοράς σφαλμάτων PDO


    $sql_select = 'SELECT brand,model,price,image,id FROM phone';

    $statement = $pdoObject->prepare($sql_select);
    $statement->execute();

    // Αποθηκεύουμε τα αποτελέσματα σε έναν πίνακα
    $phones = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement->closeCursor();


    $sql_select_mode = 'SELECT COUNT(*) AS numListings FROM phone WHERE Account_username = :username';

    $statement = $pdoObject->prepare($sql_select_mode);
    $statement->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
    $statement->execute();
    $count = 0;
    while ($result = $statement->fetch()) {
        $count++;
    }


    if ($count > 0) {
        // Αν ο χρήστης έχει κάνει ήδη καταχώρηση, τότε το mode είναι "update"
        $mode = "update";
    } else {
        // Αν ο χρήστης δεν έχει κάνει καταχώρηση, τότε το mode είναι "insert" 
        $mode = "insert";
    }

    $statement->closeCursor();
    $pdoObject = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>



<!doctype html>
<html>

<head>
    <?php require('headPart.php'); ?>


</head>

<body>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <div class="main_container" id="blur">
        <header>
            <?php require('navbar.php');
            ?>
        </header>

        <main class="platformContainer" id="blur">

            <?php
            if (isset($_SESSION['username'])) {

                echo '<div class="platformButtons">';
                echo '<button id="placeOrder_btn"><a href="placeListing.php?mode=' . $mode . '">List Your Mobile for Sale</a></button>';
                echo '<i class="fa-regular fa-trash-can" id="deleteButton"></i>';
                echo '</div>';
            } else {
                echo '<div id="Discover_Label"><div class="Discover_text">Discover</div></div>';
            } ?>
            <div class="itemsContainer">
                <?php
                if (empty($phones)) {
                    echo '<div id="emptyPlatform">There are not phones available for now. Check later</div>';
                } else {


                    foreach ($phones as $phone) : ?>

                        <div class="SingleItemContainer">
                            <a href="inspectPhone.php?id=<?php echo $phone['id']; ?>">
                                <div class="item">

                                    <img id="item_image" src="data:image/jpeg;base64,<?php echo base64_encode($phone['image']); ?>" />
                                    <div class="phone"><?php echo $phone['brand'] . " " . $phone['model']; ?></div>
                                    <div class="push phone"><?php echo $phone['price']; ?>€</div>
                                </div>
                            </a>
                        </div>
                <?php endforeach;
                } ?>
            </div>
        </main>

        <?php require('footer.php') ?>


    </div>
    <div id="alertBox">

        <i class="fa-solid fa-circle-exclamation"></i>
        <h2>Confirm</h2>
        <div id="alertLabel">Do you really want to delete your listing?</div>
        <div id="confirm_buttons">
            <button id="yes"><a href=con_deleteListing.php>OK</a></button>
            <button id="no">CANCEL</button>
        </div>
    </div>
    <script src="scripts/deleteHandle.js" type="text/javascript"></script>


</body>

</html>