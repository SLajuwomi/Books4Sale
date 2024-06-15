<?php
session_start();

$db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");

if (!$db) {
    header("Location: error.php?error=db_connect");
    return;
}

function xss_filter($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function logged_in()
{
    return isset($_SESSION['user_id']);
}

function can_change($user_id)
{
    if (!logged_in()) return FALSE;
    return $user_id = $_SESSION['user_id'];
}
if (!can_change($_SESSION['user_id'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sell Boring Literature</title>
        <link href="styles.css" rel="stylesheet">
    </head>

    <body>

        <div class="menu">
            <main>
                <h1>Books 4 Sale</h1>
                <div class="topnav">
                    <a class="active" href="#home">Home</a>
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
                    <img src="https://www.iconpacks.net/icons/2/free-opened-book-icon-3163-thumb.png" alt="coffee icon" />
                    <h2>Current Listings</h2>
                    <?php
                    $result = pg_query($db, "SELECT title, price, book_id FROM stephen.books ORDER BY price, title");
                    // $id = pg_query($db, "SELECT book_id FROM stephen.books WHERE title='$title'");
                    $n = pg_num_rows($result);
                    for ($i = 0; $i < $n; $i++) {
                        $title = pg_fetch_result($result, $i, 0);
                        $price = pg_fetch_result($result, $i, 1);
                        $id = pg_fetch_result($result, $i, 2);
                    ?>
                        <section>
                            <article class="item">
                                <p class="title"><?php echo xss_filter($title); ?></p>
                                <p class="price"><?php echo "$" . xss_filter($price); ?></p>
                            </article>
                        </section>
                    <?php
                    }
                    ?>
                <?php
            } else {
                ?>
                    <!DOCTYPE html>
                    <html lang="en">

                    <head>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <title>Sell Boring Literature</title>
                        <link href="styles.css" rel="stylesheet">
                    </head>

                    <body>

                        <div class="menu">
                            <main>
                                <h1>Books 4 Sale</h1>
                                <div class="topnav">
                                    <a class="active" href="#home">Home</a>
                                    <a href="addbook.php">Add Book</a>
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
                                    <img src="https://www.iconpacks.net/icons/2/free-opened-book-icon-3163-thumb.png" alt="coffee icon" />
                                    <h2>Current Listings</h2>
                                    <?php
                                    $result = pg_query($db, "SELECT title, price, book_id FROM stephen.books ORDER BY price, title");
                                    // $id = pg_query($db, "SELECT book_id FROM stephen.books WHERE title='$title'");
                                    $n = pg_num_rows($result);
                                    for ($i = 0; $i < $n; $i++) {
                                        $title = pg_fetch_result($result, $i, 0);
                                        $price = pg_fetch_result($result, $i, 1);
                                        $id = pg_fetch_result($result, $i, 2);
                                    ?>
                                        <section>
                                            <article class="item">
                                                <p class="title"><a href="bookdetail.php?book_id=<?php echo $id; ?>"><?php echo xss_filter($title); ?></a> </p>
                                                <p class="price"><?php echo "$" . xss_filter($price); ?></p>
                                            </article>
                                        </section>
                                    <?php
                                    }
                                    ?>
                                <?php
                            } ?>
                                </div>
                            </main>
                        </div>
                    </body>