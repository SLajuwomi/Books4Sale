<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		session_start();
		$db= pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");
		
		if (!$db) {
			header("Location: error.php?error=db_connect");
			return;
		}


		$email= strtolower(trim($_POST['email']));
		$email= pg_escape_string($email);

		$error_msg='Login failed.';
		$sql= "SELECT * FROM stephen.sayit_users WHERE email='$email'";
		$result= pg_query($db, $sql);
		if (pg_num_rows($result) == 1) {
			$db_password= pg_fetch_result($result, 0, 3);
			if(password_verify($_POST['password'], $db_password)) {
				$error_msg='';
				$_SESSION['user_id']=pg_fetch_result($result, 0, 0);
				header('Location: ./index.php');
				return;
			}
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
			<input type="text" name="email" id="email" placeholder="youremail@example.com" value="<?php echo $email;?>">
			<br>
			<label for="password">Password</label>
			<br>
			<input type="password" name="password" id="password">
			<br>
			<div class="error"><?php echo $error_msg;?></div>
			<button>Log Me In</button>
		</form>
	</div>
</body>
</html>


