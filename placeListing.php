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
            <?php
            require('navbar.php');
            require('functions.php');
            ?>

        </header>


        <main class="platformContainer">
            <div class="itemsContainer" style="padding:0;">
                <a href="platform.php" class="backToPlatform"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>
                <h1>Specs In, Sale Out!</h1>
                <?php if (isset($_GET['msg'])) { ?>
                    <div id="placeListingServerError">
                        <?php echo filterized_msg($_GET['msg']) ?>
                    </div>
                <?php } ?>

                <form method="post" action="con_placeListing.php" enctype="multipart/form-data">

                    <div id="listingContainer">
                        <div class="flexBox_label_input">
                            <?php

                            if ($_GET['mode'] == "update") {
                                require('con_db.php');

                                try {
                                    $pdoObject = new PDO("mysql:host=$dbhost;dbname=$dbname;", $dbuser, $dbpass);
                                    $pdoObject->exec('set names utf8');
                                    $pdoObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ενεργοποίηση λειτουργίας αναφοράς σφαλμάτων PDO

                                    $sql_selection = 'SELECT brand,model,color,ramSize,cores,storageSize,osVersion,
                                                    releaseDate,price,description,image
                                                    FROM phone WHERE Account_username = :username';

                                    $statement = $pdoObject->prepare($sql_selection);
                                    $statement->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
                                    $statement->execute();


                                    $phone = $statement->fetch(PDO::FETCH_ASSOC);

                                    $statement->closeCursor();
                                    $pdoObject = null;
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                            }
                            ?>
                            <input type="text" name="brand" id="brand" size="8" value="<?php if (!empty($phone['brand'])) {
                                                                                            echo $phone['brand'];
                                                                                        } else {
                                                                                            echo '';
                                                                                        } ?>">
                            <label for="brand">Brand</label>
                            <div class="invalidDataPlacing" id="invalidBrand"></div>
                        </div>

                        <div class="flexBox_label_input">
                            <input type="text" name="model" id="model" size="8" value="<?php if (!empty($phone['model'])) {
                                                                                            echo $phone['model'];
                                                                                        } else {
                                                                                            echo '';
                                                                                        } ?>">
                            <label for="model">Model</label>
                            <div class="invalidDataPlacing" id="invalidModel"></div>
                        </div>

                        <div class="flexBox_label_input">
                            <input type="text" name="color" id="color" value="<?php if (!empty($phone['color'])) {
                                                                                    echo $phone['color'];
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>">
                            <label for="color">Color</label>
                            <div class="invalidDataPlacing" id="invalidcolor"></div>
                        </div>

                        <div class="flexBox_label_input">
                            <input type="text" name="ramSize" id="ramSize" value="<?php if (!empty($phone['ramSize'])) {
                                                                                        echo $phone['ramSize'];
                                                                                    } else {
                                                                                        echo '';
                                                                                    } ?>">
                            <label for="ramSize">Ram Size</label>
                            <div class="invalidDataPlacing" id="invalidRamSize"></div>
                        </div>

                        <div class="flexBox_label_input">
                            <input type="text" name="cores" id="cores" value="<?php if (!empty($phone['cores'])) {
                                                                                    echo $phone['cores'];
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>">
                            <label for="cores">Cores</label>
                            <div class="invalidDataPlacing" id="invalidCores"></div>
                        </div>

                        <div class="flexBox_label_input">
                            <input type="text" name="storageSize" id="storageSize" value="<?php if (!empty($phone['storageSize'])) {
                                                                                                echo $phone['storageSize'];
                                                                                            } else {
                                                                                                echo '';
                                                                                            } ?>">
                            <label for="storageSize">Storage Size</label>
                            <div class="invalidDataPlacing" id="invalidStorageSize"></div>
                        </div>

                        <div class="flexBox_label_input">
                            <input type="text" name="osVersion" id="osVersion" value="<?php if (!empty($phone['osVersion'])) {
                                                                                            echo $phone['osVersion'];
                                                                                        } else {
                                                                                            echo '';
                                                                                        } ?>">
                            <label for="osVersion">OS Version</label>
                            <div class="invalidDataPlacing" id="invalidOsVersion"></div>
                        </div>

                        <div class="flexBox_label_input">
                            <input type="date" name="releaseDate" id="releaseDate" min="1995-01-01" max="2024-12-31">
                            <label for="releaseDate">Release Date</label>
                        </div>

                        <div class="flexBox_label_input">
                            <input type="text" name="price" id="price" value="<?php if (!empty($phone['price'])) {
                                                                                    echo $phone['price'];
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>">
                            <label for="price">Price (€)</label>
                            <div class="invalidDataPlacing" id="invalidPrice"></div>
                        </div>
                    </div>

                    <div id="flexbox_bottom_inputs">
                        <div id="flexbox_input_file">
                            <input type="file" name="imageUpload" id="imageUpload" accept=".jpg" hidden>
                            <label for="imageUpload">Upload image<i class="fa-solid fa-upload"></i></label>
                            <span id="imageName"></span>
                            <span id="invalidFile"></span>
                        </div>
                        <div id="flexbox_textArea">
                            <label for="descreption">Description<span id="optional">&nbsp;(optional)</span></label>
                            <textarea id="Descreption" name="descreption" rows="6" maxlength="250"><?php if (!empty($phone['description'])) {
                                                                                                                echo $phone['description'];
                                                                                                            } else {
                                                                                                                echo '';
                                                                                                            } ?></textarea>
                            <div id="letter_counter">
                                <span class="lettersCounter" id="starting_counter">0</span>
                                <span class="lettersCounter">/250</span>
                            </div>

                        </div>

                    </div>
                    <p>
                        <input type="submit" id="submitBtn" value="Upload">
                    </p>

                </form>
            </div>
        </main>

        <?php require('footer.php') ?>
    </div>
    <script type="text/javascript" src="scripts/placeListingValidator.js"> </script>
</body>

</html>