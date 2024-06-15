<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$db= pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");
		if (!$db) {
			header("Location: error.php?error=db_connect");
			return;
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
		<form method="POST" action="./login.php">
			<label for="email">Email</label>
			<br>
			<input type="text" name="email" id="email" placeholder="youremail@example.com">
			<br>
			<label for="password">Password</label>
			<br>
			<input type="password" name="password" id="password">
			<br>
			<div class="error"></div>
			<button>Log Me In</button>
		</form>
	</div>
</body>
</html>


