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

function csrf_passes($post)
{
    if (!isset($_SESSION['csrf_token'])) return FALSE;
    if (!isset($_POST['csrftok'])) return FALSE;
    error_log("SESSION: " . $_SESSION['csrf_token']);
    error_log("POST: " . $_POST['csrftok']);
    return $_SESSION['csrf_token'] == $_POST['csrftok'];
}

if (!isset($_POST['book_id']) || empty($_POST['book_id'])) {
    echo 'error';
    exit;
}


$id = htmlspecialchars($_POST['book_id']);

$query = "SELECT * FROM stephen.books WHERE book_id = $id";
$result = pg_query($db, $query);
$user_id = pg_fetch_result($result, 0, 4);
// error_log("User ID: " . $user_id);
if (!can_change($user_id)) {
    echo "error";
    return;
}

$query = "DELETE FROM stephen.books WHERE book_id = $id";
$result = pg_query($db, $query);


if (!$result || !(pg_num_rows($result) === 0)) {
    echo "error";
    exit;
}

// header("Location: ./index.php");
exit;
?>
<input type="hidden" name="csrftok" value="<?php echo $csrf_token; ?>">

