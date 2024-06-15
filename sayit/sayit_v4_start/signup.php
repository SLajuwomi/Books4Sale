<?php
	$email= '';
	$screen_name= '';

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$db= pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");
		if (!$db) {
			header("Location: error.php?error=db_connect");
			return;
		}

		function already_exists($db, $field, $value) {
			if ($field != 'email' && $field != 'screen_name') return FALSE;
			$value= pg_escape_string($value);
			$sql= "SELECT user_id FROM sergeant.sayit_users WHERE $field='$value'";
			$result= pg_query($db, $sql);
			return pg_num_rows($result) != 0;
		}

		$error_msg= '';

		$email= strtolower(trim($_POST['email']));
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error_msg.= "Invalid email address.<br>";
		} else if (already_exists($db, 'email', $email)) {
			$error_msg.= "Email address exists.<br>";
		}

		$screen_name= trim($_POST['screen-name']);
		if (strlen($screen_name) == 0 || strlen($screen_name)>20) {
			$error_msg.= "Screen name must be provided and have at most 20 characters.<br>";
		}

		$password= trim($_POST['password']);
		$cpassword= trim($_POST['confirm-password']);
		if (strlen($password) < 10) {
			$error_msg.= "Password must have at least 10 characters.";
		} else if ($password != $cpassword) {
			$error_msg.= "Password fields must match.";
		}

		if ($error_msg == '') {
			// create a new account

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
</head>
<body>
	<h1>Say It!&trade;</h1>
	<h2>Login Form!</h2>
	<div style="margin-left:200px">
		<form method="POST" action="./signup.php">
			<label for="email">Email</label>
			<br>
			<input type="text" name="email" id="email" placeholder="youremail@example.com">
			<br>
			<label for="screen-name">Screen Name</label>
			<br>
			<input type="text" id="screen-name" name="screen-name">
			<br>
			<label for="password">Password</label>
			<br>
			<input type="password" name="password" id="password">
			<br>
			<label for="confirm-password">Confirm Password</label>
			<br>
			<input type="password" name="confirm-password" id="confirm-password">
			<br>
			<div class="error"><?php echo $error_msg;?></div>
			<button>Sign Me Up</button>
		</form>
	</div>
</body>
</html>
