<?php
	session_start();

	$db= pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");
	if (!$db) {
		header("Location: error.php?error=db_connect");
		return;
	}

	function xss_filter($str) {
		return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
	}

	function csrf_passes($post) {
		if (!isset($_SESSION['csrf_token'])) return FALSE;
		if (!isset($_POST['csrftok'])) return FALSE;
		return $_SESSION['csrf_token'] == $_POST['csrftok'];
	}

	$topic= '';
	$message= '';
	$topic_error= '';
	$message_error= '';
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (isset($_POST['modify-button'])) {
			$msg_id= $_POST['msg-id'];
			if (ctype_digit($msg_id)) {
				$sql= "SELECT * FROM sergeant.get_all_messages WHERE message_id=$msg_id";
				$result= pg_query($db, $sql);
				$topic= pg_fetch_result($result, 0, 5);
				$message= pg_fetch_result($result, 0, 6);
			}
		}
		else if (isset($_POST['delete-button'])) {
			$msg_id= $_POST['msg-id'];
			if (csrf_passes($_POST) && ctype_digit($msg_id)) {
				$sql= "DELETE FROM sergeant.sayit_messages WHERE message_id=$msg_id";
				$result= pg_query($db, $sql);
			}
		}
		else {
			// We are inserting or modifying a message
			if ($_POST['new-topic']=='') {
				$topic= $_POST['existing-topic'];
			}
			else {
				$topic= $_POST['new-topic'];
			}

			$topic= ucwords(trim($topic));
			$message= trim($_POST['message']);

			$topic_error= '';
			if ($topic=='' || strlen($topic)>100) {
				$topic_error= 'Topic names are limited to 100 characters (you had ' . strlen($topic) . ' chars)';
			}
			$message_error= '';
			if ($message=='' || strlen($message)>500) {
				$message_error= 'Messages must exist and are limited to 500 characters (you had ' . strlen($message) . ' chars)';
			}


			if (csrf_passes($_POST) && $topic_error=='' && $message_error=='') {
				$topic= pg_escape_string($topic);
				$message= pg_escape_string($message);

				if (isset($_POST['update-msg-id'])) {
					// this is an update
					$msg_id= $_POST['update-msg-id'];
					if (ctype_digit($msg_id)) {
						$sql= "UPDATE sergeant.sayit_messages SET topic='$topic', message='$message' WHERE message_id=$msg_id";
						$result= pg_query($db, $sql);
					}
				}
				else {
					// this is an insert
					$sql= "INSERT INTO sergeant.sayit_messages (message_id, user_id, ts, topic, message) VALUES (default, 2, CURRENT_TIMESTAMP, '$topic', '$message')";
					$result= pg_query($db, $sql);
				}
			}
			$message= '';
			$topic= '';
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
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		crossorigin="anonymous"></script>
	<script src="js/sayit.js" defer></script>
</head>
<body>
	<h1>Say It!&trade;</h1>
	<div class="grid_6">
		<h2>What's Been Said ...</h2>
		<div id="beensaid">
			<?php
			$csrf_token= base64_encode(md5(mt_rand()));
			$_SESSION['csrf_token']= $csrf_token;
			$sql= "SELECT * FROM sergeant.get_recent_messages";
			$result= pg_query($db, $sql);
			$n= pg_num_rows($result);
			for ($i=0; $i<$n; $i++) {
				$msg_id= pg_fetch_result($result, $i, 0);
				$who= pg_fetch_result($result, $i, 3);
				$ts= pg_fetch_result($result, $i, 4);
				$ts= preg_replace("/\.\d+$/", '', $ts);
				$db_topic= pg_fetch_result($result, $i, 5);
				$db_message= pg_fetch_result($result, $i, 6);
				?>
				<section>
					<form method="POST" action="./index.php">
						<button name="modify-button">Change</button>
						<button name="delete-button">Delete</button>
						<input type="hidden" name="msg-id" value="<?php echo $msg_id;?>">
						<input type="hidden" name="csrftok" value="<?php echo $csrf_token;?>">
					</form>
					<span class="ts"><?php echo $ts;?></span>
					<span class="topic"><?php echo xss_filter($db_topic);?></span>
					<span class="who"><?php echo xss_filter($who);?> says</span>
					<?php echo xss_filter($db_message);?>
				</section>
				<?php
			}
			?>
		</div>
		<button class="big-button" id="update">Update!</button>
	</div>

	<div class="grid_6">
		<h2>Say It Yourself ...</h2>
		<div id="sayit">
			<form method="post" action="./index.php">
				<label>Topic:</label>
				<select name="existing-topic">
					<?php
						$sql= "SELECT * FROM sergeant.get_topic_list";
						$result= pg_query($db, $sql);
						$n= pg_num_rows($result);
						$topic_exists= FALSE;
						for ($i=0; $i<$n; $i++) {
							$db_topic= pg_fetch_result($result, $i, 0);
							$topic_out= xss_filter($db_topic);
							if ($topic==$db_topic) {
								$topic_exists= TRUE;
								echo "<option selected=\"selected\">$topic_out</option>\n";
							}
							else {
								echo "<option>$topic_out</option>\n";
							}
						}
					?>
				</select>
				or
				<input type="text" name="new-topic" value="<?php echo $topic_exists ? '' : $topic;?>"/>
				<div class="error"><?php echo $topic_error;?></div>
				<div class="clear"></div>
				<div class="error"><?php echo $message_error;?></div>
				<div class="clear"></div>
				<label>Message (limit 500 chars)</label><br/>
				<textarea name="message"><?php echo $message;?></textarea>
				<?php
				if (isset($_POST['modify-button'])) {
					echo '<input type="hidden" name="update-msg-id" value="' .  $_POST['msg-id'] . '">' . "\n";
				}
				?>
				<input type="hidden" name="csrftok" value="<?php echo $csrf_token;?>">
				<button class="big-button">Say It!</button>
			</form>
		</div>
	</div>
</body>
<?php
if (isset($_POST['modify-button']) || $topic_error != '' || $message_error != '') {
	?>
	<script>
	$('html,body').animate({scrollTop: document.body.scrollHeight},"slow");
	</script>
	<?php
}
?>
</html>


