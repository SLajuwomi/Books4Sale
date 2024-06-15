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

if (!isset($_POST['msg_id']) || !isset($_POST['csrftok']) || !ctype_digit($_POST['msg_id'])) {
    echo "error";
    return;
}

if (!logged_in()) {
    echo "error";
    return;
}

$msg_id = $_POST['msg_id'];
$sql = "SELECT * FROM stephen.get_all_messages WHERE message_id=$1";
$result = pg_query_params($db, $sql, array($msg_id));
if (!$result) {
    echo "error";
    return;
}
$user_id = pg_fetch_result($result, 0, 1);
$email = pg_fetch_result($result, 0, 2);
$screen_name = pg_fetch_result($result, 0, 3);
$ts = pg_fetch_result($result, 0, 4);
$topic = pg_fetch_result($result, 0, 5);
$message = pg_fetch_result($result, 0, 6);
$csrf_token= $_POST['csrftok'];


?>
<div class="detail-box">
    <table>
        <tr>
            <th>Time</th>
            <td><?php echo $ts;?></td>
        </tr>
        <tr>
            <th>Topic</th>
            <td><?php echo xss_filter($topic);?></td>
        </tr>
        <tr>
            <th>Message</th>
            <td><?php echo xss_filter($message);?></td>
        </tr>
        <tr>
            <th>Author Name</th>
            <td><?php echo xss_filter($screen_name);?></td>
        </tr>
        <tr>
            <th>Author email</th>
            <td><?php echo $email;?></td>
        </tr>

    </table>
    <?php 
    if (can_change($user_id)) {
        ?>
    <form method="POST" action="./index.php">
        <button name="modify-button">Change</button>
        <button name="delete-button">Delete</button>
        <input type="hidden" name="msg-id" value="<?php echo $msg_id;?>">
        <input type="hidden" name="csrftok" value="<?php echo $csrf_token;?>">
    </form>
    <?php
    } ?>    
</div>