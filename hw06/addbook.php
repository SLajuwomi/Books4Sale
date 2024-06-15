<?php
session_start();

$db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");




$booktitle_error = '';
$bookcondition_error = '';
$book_price_error = '';
$clean_book_id = '';

if (!$db) {
    header("Location: error.php?error=db_connect");
    return;
}



// error_log("SESSION: " . $_SESSION['csrf_token']);

function logged_in()
{
    return isset($_SESSION['user_id']);
}

function can_change($user_id)
{
    if (!logged_in()) return FALSE;
    return $user_id == $_SESSION['user_id'];
}

function csrf_passes($post)
{
    if (!isset($_SESSION['csrf_token'])) return FALSE;
    if (!isset($_POST['csrftok'])) return FALSE;
    return $_SESSION['csrf_token'] == $_POST['csrftok'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booktitle = trim($_POST['booktitle']);
    $bookcondition = trim($_POST['bookcondition']);
    $price = trim($_POST['price']);

    if ($booktitle == '' || strlen($booktitle) > 100) {
        $booktitle_error = 'Book titles must exist cannot have more than 100 characters (you had ' . strlen($booktitle) . ' chars)';
    }

    if ($bookcondition == '') {
        $bookcondition_error = 'Book conditions must exist';
    }

    if ($price == '' || strlen($price) > 99) {
        $book_price_error = 'Book price must exist and cannot have more than 6 digits (you had ' . strlen($price) . ' digits)';
    }


    // error_log("CSRF: " . csrf_passes($_POST));
    // error_log("Book title: " . $booktitle_error);
    // error_log("Book condition: " . $bookcondition_error);
    // error_log("Book price: " . $book_price_error);

    if (csrf_passes($_POST) && $booktitle_error == '' && $bookcondition_error == '' && $book_price_error == '') {
        // error_log("Beginning of POST: " . $_POST['booktitle']);
        $booktitle = pg_escape_string($booktitle);
        $bookcondition = pg_escape_string($bookcondition);
        $price = pg_escape_string($price);

        if (isset($_POST["update_book_id"])) {
            // error_log("POST the GET: " . $_POST['update_book_id']);

            $clean_book_id = filter_var(($_POST["update_book_id"]),
                FILTER_SANITIZE_NUMBER_INT,
                $options = array(
                    'options' => array(
                        'min_range' => 1
                    )
                )
            );

            $query = "SELECT * FROM stephen.books WHERE book_id = $clean_book_id";
            $result = pg_query($db, $query);
            $user_id = pg_fetch_result($result, 0, 4);
            // error_log("User ID: " . $user_id);
            if (!can_change($user_id)) {
                header('Location: ./index.php');
                return;
            }
            $sql = "UPDATE stephen.books SET title='$booktitle', condition='$bookcondition', price='$price', updated_at=default WHERE book_id=$clean_book_id";
            $result = pg_query($db, $sql);
            if ($result) {
                header("Location: ./index.php");
                return;
            } else {
                header("Location: error.php?error=query_invalid");
                return;
            }
        }

        // $query = "SELECT * FROM stephen.books WHERE book_id = $id";
        // $result = pg_query($db, $query);
        // $user_id = pg_fetch_result($result, 0, 4);
        // // error_log("User ID: " . $user_id);
        // if (!can_change($user_id)) {
        //     header('Location: ./index.php');
        //     return;
        // }

        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO stephen.books (book_id, title, condition, price, created_by, created_at, updated_at) 
                    VALUES (default, '$booktitle', '$bookcondition', '$price', '$user_id', default, NULL )";
        $result = pg_query($db, $sql);
        if ($result) {
            header("Location: ./index.php");
            return;
        } else {
            header("Location: error.php?error=query_invalid");
            return;
        }
        // error_log("POST book_id: " . $_POST['book_id']);

    }
}


// error_log("GET (outside): " . $_GET["book_id"]);

if ((isset($_GET["book_id"]))) {

    // error_log("GET: " . $_GET["book_id"]);

    $clean_book_id = filter_var(($_GET["book_id"]),
        FILTER_SANITIZE_NUMBER_INT,
        $options = array(
            'options' => array(
                'min_range' => 1
            )
        )
    );
    // error_log("Clean book id: " . $clean_book_id);
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
                <?php
                if (logged_in()) {
                    echo '<a href="logout.php">Logout</a>';
                } else {
                    echo '<a href="login.php">Login</a>';
                    echo '<a href="signup.php">Signup</a>';
                } ?>
            </div>
            <hr>
            <div class="menu">
                <section>
                    <img src="https://www.iconpacks.net/icons/2/free-opened-book-icon-3163-thumb.png" alt="coffee icon" />
                    <h2>Add a Book</h2>
                </section>
                <div class="form">
                    <?php
                    $csrf_token = base64_encode(md5(mt_rand()));
                    $_SESSION['csrf_token'] = $csrf_token;
                    $user_id = $_SESSION['user_id'];
                    if (!can_change($user_id)) {
                        header('Location: ./index.php');
                        return;
                    }

                    $bid = $_GET['book_id'];
                    $query1 = "SELECT * FROM stephen.books WHERE book_id = $bid";
                    $result1 = pg_query($db, $query1);
                    $old_title = pg_fetch_result($result1, 0, 1);
                    $old_condition = pg_fetch_result($result1, 0, 2);
                    $old_price = pg_fetch_result($result1, 0, 3);
                    ?>
                    <form name="add-new" method="POST" action="">
                        <section role="booktitle">
                            <div class="booktitle-entry">
                                <label for="booktitle">Book Title:</label>
                                <input type="text" name="booktitle" id="booktitle" value="<?php echo $old_title; ?>" />
                                <?php
                                if ($booktitle_error != '') {
                                    echo '<p class="errors">' . $booktitle_error . '</p>';
                                } ?>
                            </div>
                        </section>
                        <section role="condition">
                            <div class="bookcondition-entry">
                                <label for="bookcondition">Book Condition:</label>
                                <select name="bookcondition" id="bookconditon" >
                                    <option value="">Select an option</option>
                                    <option value="1">1=poor</option>
                                    <option value="2">2=fair</option>
                                    <option value="3">3=good</option>
                                    <option value="4">4=excellent</option>
                                </select>
                            </div>
                            <?php
                            if ($bookcondition_error != '') {
                                echo '<p class="errors">' . $bookcondition_error . '</p>';
                            } ?>
                        </section>
                        <section role="price">
                            <div class="price-entry">
                                <label for="price">Book Price:</label>
                                <input type="text" name="price" id="price"  value="<?php echo $old_price; ?>"/>
                                <?php
                                if ($book_price_error != '') {
                                    echo '<p class="errors">' . $book_price_error . '</p>';
                                } ?>
                            </div>
                        </section>
                        <?php
                        if (isset($_GET['book_id'])) {
                            // error_log("HIDDEN: " . $_GET["book_id"]);
                            echo '<input type="hidden" name="update_book_id" value="' .  $clean_book_id . '">' . "\n";
                        }
                        ?>
                        <input type="hidden" name="csrftok" value="<?php echo $csrf_token; ?>">
                        <?php
                        if (isset($_GET['book_id'])) {
                        ?>
                            <input type="submit" value="Update">
                        <?php
                        } else {
                        ?>
                            <input type="submit" value="Submit">
                        <?php
                        }
                        ?>
                    </form>

                </div>

            </div>
    </div>
</body>