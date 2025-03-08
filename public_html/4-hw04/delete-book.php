<?php
$db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");

if (!$db) {
    header("Location: error.php?error=db_connect");
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


if (!isset($_GET['book_id']) || empty($_GET['book_id'])) {
    header("Location: error.php?error=missing_book_id");
    exit;
}


$id = htmlspecialchars($_GET['book_id']);


$query = "DELETE FROM stephen.books WHERE book_id = $id";

if (!$query) {
    header("Location: error.php?error=query_invalid");
    return;
}

$result = pg_query($db, $query);

if (!$result || !(pg_num_rows($result) === 0)) {
    header("Location: error.php?error=delete_failed");
    exit;
}

header("Location: index.php");
exit;
