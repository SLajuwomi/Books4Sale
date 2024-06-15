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

$topic = '';
$message = '';
$topic_error = '';
$message_error = '';

/*if (isset($_POST["message"]))*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (isset($_POST['modify-button'])) {
		error_log("Modify button clicked");
		error_log(print_r($_POST, TRUE));
		// Pull messages from database
		$msg_id = $_POST['msg-id'];
		if (ctype_digit($msg_id)) {
			$sql = "SELECT * FROM stephen.get_all_messages WHERE message_id=$msg_id";
			$result = pg_query($db, $sql);
			$topic = pg_fetch_result($result, 0, 5);
			$message = pg_fetch_result($result, 0, 6);
			$user_id = pg_fetch_result($result, 0, 1);
			if (!can_change($user_id)) {
				header('Location: ./index.php');
				return;
			}
		}
	} else if (isset($_POST['delete-button'])) {

		error_log("Delete button clicked");
		error_log(print_r($_POST, TRUE));
		$msg_id = $_POST['msg-id'];

		if (csrf_passes($_POST) && ctype_digit($msg_id)) {
			$sql = "SELECT * FROM stephen.get_all_messages WHERE message_id=$msg_id";
			$result = pg_query($db, $sql);
			$user_id = pg_fetch_result($result, 0, 1);
			if (!can_change($user_id)) {
				header('Location: ./index.php');
				return;
			}
			$sql = "DELETE FROM stephen.sayit_messages WHERE message_id=$msg_id";
			pg_query($db, $sql);
		}
		// header("Location: index.php");
	} else {
		// We are inserting or modifying a message
		if ($_POST['new-topic'] == '') {
			$topic = $_POST['existing-topic'];
		} else {
			$topic = $_POST['new-topic'];
		}

		$topic = ucwords(trim($topic));
		$message = trim($_POST['message']);

		$topic_error = '';
		if ($topic == '' || strlen($topic) > 100) {
			$topic_error = 'Topic names are limited to 100 characters (you had ' . strlen($topic) . ' chars)';
		}

		$message_error = '';
		if ($message == '' || strlen($message) > 100) {
			$message_error = 'Messages must exist and are limited to 500 characters (you had ' . strlen($message) . ' chars)';
		}

		if (csrf_passes($_POST) &&  $topic_error == '' && $message_error == '') {
			$topic = pg_escape_string($topic);
			$message = pg_escape_string($message);
			if (isset($_POST['update-msg-id'])) {
				//this is update
				$msg_id = $_POST['update-msg-id'];
				if (ctype_digit($msg_id)) {
					$sql = "SELECT * FROM stephen.get_all_messages WHERE message_id=$msg_id";
					$result = pg_query($db, $sql);
					$user_id = pg_fetch_result($result, 0, 1);
					if (!can_change($user_id)) {
						header('Location: ./index.php');
						return;
					}
					error_log("Update SQL:" . $message);
					$sql = "UPDATE stephen.sayit_messages SET topic='$topic', message='$message' WHERE message_id=$msg_id";
					$result = pg_query($db, $sql);
				}
			} else {
				//this is insert
				if (!logged_in()) {
					header('Location: ./index.php');
					return;
				}
				$sql = "INSERT INTO stephen.sayit_messages (message_id, user_id, ts, topic,
				message) VALUES (default, $_SESSION[user_id], CURRENT_TIMESTAMP, '$topic', '$message')";
				$result = pg_query($db, $sql);
			}
		}
		$message = '';
		$topic = '';
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Say It!</title>
	<link href="css/sayit.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Dosis' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Asul' rel='stylesheet' type='text/css'>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="js/sayit.js" defer></script>
</head>

<body>
	<h1>Say It!&trade;
		<?php
		if (logged_in()) {
			echo '<a class="button" href="./logout.php">Logout</a>' . "\n";
		} else {
			echo '<a class="button" href="./login.php">Login</a>' . "\n";
			echo '<a class="button" href="./signup.php">Signup</a>' . "\n";
		}
		?>
		<!-- <a class="button" href="./logout.php">Logout</a>
		<a class="button" href="./login.php">Login</a>
		<a class="button" href="./signup.php">Signup</a> -->
	</h1>
	<div class="grid_6">
		<h2>What's Been Said ...</h2>
		<div id="beensaid">
			<?php
			$csrf_token = base64_encode(md5(mt_rand()));
			$_SESSION['csrf_token'] = $csrf_token;
			$sql = "SELECT * FROM stephen.get_recent_messages";
			$result = pg_query($db, $sql);
			$n = pg_num_rows($result);
			for ($i = 0; $i < $n; $i++) {
				$msg_id = pg_fetch_result($result, $i, 0);
				$who = pg_fetch_result($result, $i, 3);
				$ts = pg_fetch_result($result, $i, 4);
				$ts = preg_replace("/\.\d+$/", '', $ts);
				$db_topic = pg_fetch_result($result, $i, 5);
				$db_message = pg_fetch_result($result, $i, 6);
				$user_id = pg_fetch_result($result, $i, 1);
			?>
				<section id="bid_<?php echo $msg_id;?>">
					<div class="content">
					<span class=" topic"><?php echo xss_filter($db_topic); ?></span>
						<span class="who"><?php echo xss_filter($who); ?></span>
						<?php echo xss_filter($db_message); ?>
					</div>
					<hr>
				</section>
			<?php
			}
			?>
		</div>
		<button class="big-button" id="update">Update!</button>
	</div>

	<?php
	if (logged_in()) {
	?>
		<div class="grid_6">
			<h2>Say It Yourself ...</h2>
			<div id="sayit">
				<form method="POST" action="./index.php">
					<label>Topic:</label>
					<select name="existing-topic">
						<?php

						$result = pg_query($db, "SELECT * FROM stephen.get_topic_list");
						$n = pg_num_rows($result);
						$topic_exists = FALSE;
						for ($i = 0; $i < $n; $i++) {
							$db_topic = pg_fetch_result($result, $i, 0);
							$topic_out = xss_filter($db_topic);
							if ($topic == $db_topic) {
								$topic_exists = TRUE;
								echo "<option selected=\"selected\">$topic_out</option>\n";
							} else {
								echo "<option>$topic_out</option>\n";
							}
						}

						?>
					</select>
					or
					<input type="text" name="new-topic" value="<?php echo $topic_exists ? '' : $topic; ?>" />
					<div class="error"><?php echo $topic_error; ?></div>
					<div class="clear"></div>
					<div class="error"><?php echo $message_error; ?></div>
					<div class="clear"></div>
					<label>Message (limit 500 chars)</label><br />
					<textarea name="message"><?php echo $message; ?></textarea>
					<?php
					if (isset($_POST['modify-button'])) {
						echo '<input type="hidden" name="update-msg-id" value="' . $_POST['msg-id'] . '">' . "\n";
					}
					?>
					<input type="hidden" id="csrftok" name="csrftok" value="<?php echo $csrf_token; ?>">
					<button class="big-button">Say It!</button>
				</form>
			</div>
		</div>
	<?php
	}
	?>
</body>
<?php
if (isset($_POST['modify-button']) || $topic_error != '' || $message_error != '') {
?>
	<script>
		$('html,body').animate({
			scrollTop: document.body.scrollHeight
		}, "slow")
	</script>
<?php
}
?>

</html>