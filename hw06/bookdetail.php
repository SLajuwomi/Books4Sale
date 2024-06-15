<?php
session_start();
$db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");

if (!$db) {
    echo "error";
    return;
}

function xss_filter($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function csrf_passes($post)
{
    if (!isset($_SESSION['csrf_token'])) return FALSE;
    if (!isset($_POST['csrftok'])) return FALSE;
    error_log("SESSION: " . $_SESSION['csrf_token']);
    error_log("POST: " . $_POST['csrftok']);
    return $_SESSION['csrf_token'] == $_POST['csrftok'];
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

if (!$_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "error";
    return;
}


if (!isset($_POST['book_id']) || !isset($_POST['csrftok']) || !ctype_digit($_POST['book_id'])) {
    echo "error";
    return;
}

if (!logged_in()) {
    echo "error";
    return;
}


$id = $_POST['book_id'];


$user_id = $_SESSION['user_id'];
if (!can_change($user_id)) {
    header('Location: ./index.php');
    return;
}

// if (!isset($_GET['book_id']) || empty($_GET['book_id'])) {
//     header("Location: error.php?error=missing_book_id");
//     exit;
// }

$query = "SELECT book_id,title,condition,price,email 
            FROM stephen.books INNER JOIN stephen.book_users ON
            (books.created_by=book_users.user_id) WHERE book_id = $1";
$result = pg_query_params($db, $query, array($id));
if (!$result) {
    echo "error";
    return;
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
<div id="bookdetail">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="styles.css" rel="stylesheet">
</head>

<div id="popup" class="popup">
    <?php
    $csrf_token = base64_encode(md5(mt_rand()));
    $_SESSION['csrf_token'] = $csrf_token;
    ?>
    <span class="popuptext" id="myPopup">
        <section>
            <article class="item">
                <div id="book-details"></div>
                <p class="title"><?php echo xss_filter($title); ?></p>
                <p class="price"><?php echo "$" . xss_filter($price); ?></p>
                <p class="email"><?php echo "Email:" . xss_filter($email); ?></p>
            </article>
        </section>
    </span>
</div>
</div>

<?php } else { ?>

    <div id="bookdetail">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="styles.css" rel="stylesheet">
        </head>

        <div id="popup" class="popup">
            <?php
            $csrf_token = base64_encode(md5(mt_rand()));
            $_SESSION['csrf_token'] = $csrf_token;
            ?>
            <span class="popuptext" id="myPopup">
                <section>
                    <article class="item">
                        <div id="book-details"></div>
                        <p class="title"><?php echo xss_filter($title); ?></p>
                        <p class="price"><?php echo "$" . xss_filter($price); ?></p>
                        <p class="email"><?php echo "Email:" . xss_filter($email); ?></p>


                        <button><a href="addbook.php?book_id=<?php echo $id; ?>">Modify</a></button>


                        <div id="delete-button">
                            <input type="hidden" name="csrftok" value="<?php echo $csrf_token; ?>">
                            <button class="clickdelete" style="color:blue;"><u>Delete</u></button>
                        </div>
                    </article>
                </section>
            </span>
        </div>
    </div>
<?php } ?>