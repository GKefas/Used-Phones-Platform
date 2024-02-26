<?php
require('con_db.php');
$id = $_GET['id'];
$phone = [];
try {
    $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ενεργοποίηση λειτουργίας αναφοράς σφαλμάτων PDO

    $sql_select = 'SELECT 
                brand,model,color,ramSize,cores,storageSize,osVersion,
                releaseDate,price,description,image
                FROM phone WHERE id=:id';

    $statement = $pdoObject->prepare($sql_select);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    // Αποθηκεύουμε τα αποτελέσματα σε έναν πίνακα
    $phone = $statement->fetch(PDO::FETCH_ASSOC);

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
    <div class="main_container">
        <header>
            <?php require('navbar.php') ?>

        </header>
        <main class="platformContainer">
            <div class="itemsContainer">
                <a href="platform.php" class="backToPlatform"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>

                <div id="topContainer">
                    <img id="inspectImage" src="data:image/jpeg;base64,<?php echo base64_encode($phone['image']); ?>">
                    <div id="rightSide">
                        <h2><?php echo $phone['brand'] . " " . $phone['model']; ?></h2>
                        <hr id="h2ToPrice">
                        <div id="price">
                            <?php echo $phone['price'] . "€"; ?>
                        </div>
                    </div>
                </div>
                <section id="details">
                    <h2>DETAILS</h2>
                    <table>
                        <tr>
                            <td>Brand</td>
                            <td class="leftTable"><?php echo $phone['brand'] . " " . $phone['model']; ?></td>
                        </tr>
                        <tr>
                            <td>Release Date</td>
                            <td class="leftTable"><?php echo $phone['releaseDate']; ?></td>
                        </tr>
                        <tr>
                            <td>Processor Cores </td>
                            <td class="leftTable"><?php echo $phone['cores']; ?></td>
                        </tr>
                        <tr>
                            <td>RAM Size</td>
                            <td class="leftTable"><?php echo $phone['ramSize'] . " GB"; ?></td>
                        </tr>
                        <tr>
                            <td>Storage Size</td>
                            <td class="leftTable"><?php echo $phone['storageSize'] . " GB"; ?></td>
                        </tr>
                        <tr>
                            <td>Color</td>
                            <td class="leftTable"><?php echo $phone['color']; ?></td>
                        </tr>
                        <tr>
                            <td>OS Version</td>
                            <td class="leftTable"><?php echo $phone['osVersion']; ?></td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td class="leftTable"><?php echo $phone['price'] . "€"; ?></td>
                        </tr>
                    </table>
                </section>
                <section id="description">
                    <h2>Description</h2>
                    <div id="description_content">
                        <?php echo $phone['description']; ?>
                    </div>
                </section>
            </div>
        </main>

        <?php require('footer.php') ?>
    </div>
</body>

</html>