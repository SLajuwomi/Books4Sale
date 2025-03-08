<?php

$email = '';
$error_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");

    if (!$db) {
        header("Location: error.php?error=db_connect");
        return;
    }


    $email = strtolower(trim($_POST['email']));
    $email = pg_escape_string($email);

    $error_msg = 'Login failed.';
    $sql = "SELECT * FROM stephen.book_users WHERE email='$email'";
    $result = pg_query($db, $sql);
    if (pg_num_rows($result) == 1) {
        $db_password = pg_fetch_result($result, 0, 3);
        if (password_verify($_POST['password'], $db_password)) {
            $error_msg = '';
            $_SESSION['user_id'] = pg_fetch_result($result, 0, 0);
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
    <title>Login</title>
    <link href="styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		crossorigin="anonymous"></script>
</head>

<body>
    <div class="menu">
        <main>
            <h1>Books 4 Sale</h1>
            <div class="topnav">
                <a href="index.php">Home</a>
                <a class="active" href="login.php">Login</a>
            </div>
            <hr>
            <div class="menu">
                <section>
                    <img src="https://www.iconpacks.net/icons/2/free-opened-book-icon-3163-thumb.png" alt="coffee icon" />
                    <h2>Login Here</h2>
                </section>
                <form method="POST" action="./login.php">
                    <label for="email">Email</label>
                    <br>
                    <input type="text" name="email" id="email" placeholder="youremail@example.com" value="<?php echo $email; ?>">
                    <br>
                    <label for="password">Password</label>
                    <br>
                    <input type="password" name="password" id="password">
                    <br>
                    <div class="error"><?php echo '<p class="errors">' . $error_msg . '</p>'; ?></div>
                    <button>Login</button>
                    <?php
                    if (isset($_SESSION['user_id']) == FALSE) {
                        echo '<button><a class="button" href="./signup.php">Signup</a></button>' . "\n";
                    }
                    ?>
                </form>

            </div>
    </div>
</body>