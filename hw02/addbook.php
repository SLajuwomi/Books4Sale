<?php

$db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");


if (isset($_POST['booktitle'])) {
    $booktitle = trim($_POST['booktitle']);

    $bookcondition = trim($_POST['bookcondition']);

    $price = trim($_POST['price']);

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
    <link href="styles.css" rel="stylesheet">
</head>

<body>

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
                    <form method="post" action="">
                        <section role="booktitle">
                            <div class="booktitle-entry">
                                <label for="booktitle">Book Title:</label>
                                <input type="text" name="booktitle" id="booktitle" />
                                <div class="error"><?php echo $booktitle_error; ?></div>
                                <div class="clear"></div>
                            </div>
                        </section>
                        <section role="condition">
                            <label for="bookcondition">Book Condition:</label>
                            <select name="bookcondition" id="bookconditon">
                                <option value="">Select an option</option>
                                <option value="1">1=poor</option>
                                <option value="2">2=fair</option>
                                <option value="3">3=good</option>
                                <option value="4">4=excellent</option>
                            </select>
                        </section>
                        <section role="price">
                            <div class="price-entry">
                                <label for="price">Book Price:</label>
                                <input type="text" name="price" id="price" />
                            </div>
                        </section>

                        <input type="submit" value="Submit">
                    </form>

                </div>

            </div>
    </div>
</body>