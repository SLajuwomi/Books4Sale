<?php
$db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");
if (!$db) {
    header("Location: error.php?error=db_connect");
    return;
}
function xss_filter($str) {
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
if (!isset($_GET['book_id']) || empty($_GET['book_id'])) {
    header("Location: error.php?error=missing_book_id");
    exit;
}
$id = htmlspecialchars($_GET['book_id']);
$query = "SELECT title, price FROM stephen.books WHERE book_id = $id";
$result = pg_query($db, $query);
if (!$result || pg_num_rows($result) === 0) {
    header("Location: error.php?error=invalid_book_id");
    exit;
}
$n = pg_num_rows($result);
for ($i = 0; $i < $n; $i++) {
    $title = pg_fetch_result($result, $i, 0);
    $price = pg_fetch_result($result, $i, 1);
}
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
                <a href="addbook.php">Add Book</a>
                <a href="login.php">Login</a>
            </div>
            <hr>
            <div class="menu">
                <h2>Change Book Details</h2>
                <section>
                    <article class="item">
                        <p class="title"><?php echo xss_filter($title); ?></p>
                        <p class="price"><?php echo "$" . xss_filter($price); ?></p>
                        <button>Update</button>
                        <button>Delete</button>
                    </article>
                </section>
            </div>
        </main>
    </div>
</body>