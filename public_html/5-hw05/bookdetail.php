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
    return $user_id == $_SESSION['user_id'];
}

$user_id = $_SESSION['user_id'];
if (!can_change($user_id)) {
    header('Location: ./index.php');
    return;
}

if (!isset($_GET['book_id']) || empty($_GET['book_id'])) {
    header("Location: error.php?error=missing_book_id");
    exit;
}


$id = htmlspecialchars($_GET['book_id']);



$query = "SELECT book_id,title,condition,price,email 
            FROM stephen.books INNER JOIN stephen.book_users ON
            (books.created_by=book_users.user_id) WHERE book_id = $id";
$result = pg_query($db, $query);

if (!$result || pg_num_rows($result) === 0) {
    header("Location: error.php?error=invalid_book_id");
    exit;
}

$n = pg_num_rows($result);
for ($i = 0; $i < $n; $i++) {
    $title = pg_fetch_result($result, $i, 1);
    $price = pg_fetch_result($result, $i, 3);
    $email = pg_fetch_result($result, $i, 4);
}

$query = "SELECT * FROM stephen.books WHERE book_id = $id";
$result = pg_query($db, $query);
$user_id = pg_fetch_result($result, 0, 4);
// error_log("User ID: " . $user_id);
if (!can_change($user_id)) {
?>

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
                            <p class="email"><?php echo "Email:  " . xss_filter($email); ?></p>
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
                            <p class="email"><?php echo "Email:  " . xss_filter($email); ?></p>


                            <button><a href="addbook.php?book_id=<?php echo $id; ?>">Modify</a></button>


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