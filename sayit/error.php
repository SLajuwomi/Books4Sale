<?php
$msg= "Unexpected Error";
	if (isset($_GET['error'])) {
		if ($_GET['error']=='db_connect') {
			$msg= "Error connecting to database.";
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
		<h2>Something went wrong!</h2>
		<div>
			<?php echo $msg;?>
			<br>
			<a href="./index.php">Back to Work</a>
		</div>
	</div>
</body>
</html>


