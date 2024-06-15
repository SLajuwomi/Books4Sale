<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link href="styles.css" rel="stylesheet">
    </head>

    <body>
        <div class="menu">
            <main>
                <h1>Books 4 Sale</h1>
                <div class="topnav">
                    <a href="index.php">Home</a>
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
                    <h2>Change Book Details</h2>
                    <?php
                    $csrf_token = base64_encode(md5(mt_rand()));
                    $_SESSION['csrf_token'] = $csrf_token;
                    ?>
                    <section>
                        <article class="item">
                            <p class="title"><?php echo xss_filter($title); ?></p>
                            <p class="price"><?php echo "$" . xss_filter($price); ?></p>
                            <p class="email"><?php echo "Email:  ". xss_filter($email); ?></p>
                            </form>
                        </article>
                    </section>
                </div>
            </main>
        </div>
    </body>
<?php } else { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link href="styles.css" rel="stylesheet">
    </head>

    <body>
        <div class="menu">
            <main>
                <h1>Books 4 Sale</h1>
                <div class="topnav">
                    <a href="index.php">Home</a>
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
                    <h2>Change Book Details</h2>
                    <?php
                    $csrf_token = base64_encode(md5(mt_rand()));
                    $_SESSION['csrf_token'] = $csrf_token;
                    ?>
                    <section>
                        <article class="item">
                            <p class="title"><?php echo xss_filter($title); ?></p>
                            <p class="price"><?php echo "$" . xss_filter($price); ?></p>
                            <p class="email"><?php echo "Email:  ". xss_filter($email); ?></p>


                            <button><a href="addbook.php?book_id=<?php echo $id; ?>">Update</a></button>


                            <form id="delete-button" method="POST" action="./delete-book.php?book_id=<?php echo $id; ?>">
                                <input type="hidden" name="csrftok" value="<?php echo $csrf_token; ?>">
                                <button><a href="delete-book.php?book_id=<?php echo $id; ?>">Delete</a></button>
                            </form>
                        </article>
                    </section>
                </div>
            </main>
        </div>
    </body>
<?php } ?>

================================================
************************************************
================================================

<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link href="styles.css" rel="stylesheet">
    </head>

<div class="popup">
    <span class="popuptext" id="myPopup">
                    <section>
                        <article class="item">
                            <p class="title"><?php echo xss_filter($title); ?></p>
                            <p class="price"><?php echo "$" . xss_filter($price); ?></p>
                            <p class="email"><?php echo "Email:  ". xss_filter($email); ?></p>


                            <button><a href="addbook.php?book_id=<?php echo $id; ?>">Update</a></button>


                            <form id="delete-button" method="POST" action="./delete-book.php?book_id=<?php echo $id; ?>">
                                <input type="hidden" name="csrftok" value="<?php echo $csrf_token; ?>">
                                <button><a href="delete-book.php?book_id=<?php echo $id; ?>">Delete</a></button>
                            </form>
                        </article>
                    </section>
    </span>
</div>
</html>