<?php

$db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");

$booktitle_error = '';
$bookcondition_error = '';
$book_price_error = '';

if (!$db) {
    header("Location: error.php?error=db_connect");
    return;
}

if (isset($_POST['booktitle'])) {
    $booktitle = trim($_POST['booktitle']);


    if ($booktitle == '' || strlen($booktitle) > 100) {
        $booktitle_error = 'Book titles must exist cannot have more than 100 characters (you had ' . strlen($booktitle) . ' chars)';
    }

    if ($bookcondition == '') {
        $bookcondition_error = 'Book conditions must exist';
    }

    if ($book_price == '' || strlen($book_price) > 6) {
        $book_price_error = 'Book price must exist cannot have more than 6 digits (you had ' . strlen($booktitle) . ' digits)';
    }

    $bookcondition = trim($_POST['bookcondition']);

    $price = trim($_POST['price']);

    if ($booktitle_error == '') {
        $booktitle = pg_escape_string($booktitle);
        $bookcondition = pg_escape_string($bookcondition);
        $price = pg_escape_string($price);
        $sql = "INSERT INTO stephen.books (book_id, title, condition, price) 
                    VALUES (default, '$booktitle', '$bookcondition', '$price')";
        $result = pg_query($db, $sql);
    }
    if ($result) {
        header("Location: ./index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Book Form</title>
    <link href="form.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>

<body>
    <?php
    if (isset($_POST['booktitle'])) {
        $booktitle = $_POST['booktitle'];
        $bookcondition = $_POST['bookcondition'];
        $price = $_POST['price'];
        $sql = "INSERT INTO stephen.books (book_id, title, condition, price) 
                    VALUES (default, '$booktitle', '$bookcondition', '$price')";
        $db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");

        if ($db) {
            $result = pg_query($db, $sql);
            if ($result) {
                header("Location: ./index.php");
                exit();
            }
        }
    }
    ?>
    <div class="menu">
        <main>
            <h1>Books 4 Sale</h1>
            <div class="topnav">
                <a href="index.php">Home</a>
                <a class="active" href="addbook.php">Add Book</a>
                <a href="login.php">Login</a>
            </div>
            <hr>
            <div class="menu">
                <section>
                    <img src="https://www.iconpacks.net/icons/2/free-opened-book-icon-3163-thumb.png" alt="coffee icon" />
                    <h2>Add a Book</h2>
                </section>
                <div class="form">
                    <form method="post" action="">
                        <section role="booktitle">
                            <div class="booktitle-entry">
                                <label for="booktitle">Book Title:</label>
                                <input type="text" name="booktitle" id="booktitle" />
                                <div class="error"><?php echo $booktitle_error; ?></div>
                            </div>
                        </section>
                        <section role="condition">
                            <div class="bookcondition-entry">
                                <label for="bookcondition">Book Condition:</label>
                                <select name="bookcondition" id="bookconditon">
                                    <option value="">Select an option</option>
                                    <option value="1">1=poor</option>
                                    <option value="2">2=fair</option>
                                    <option value="3">3=good</option>
                                    <option value="4">4=excellent</option>
                                </select>
                            </div>
                            <div class="error"><?php echo $bookcondition_error; ?></div>
                        </section>
                        <section role="price">
                            <div class="price-entry">
                                <label for="price">Book Price:</label>
                                <input type="text" name="price" id="price" />
                                <div class="error"><?php echo $book_price_error; ?></div>
                            </div>
                        </section>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
    </div>
</body>