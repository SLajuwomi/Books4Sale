<?php
$email = '';
$name = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");
    if (!$db) {
        header("Location: error.php?error=db_connect");
        return;
    }

    function already_exists($db, $field, $value)
    {
        if ($field != 'email' && $field != 'name') return FALSE;
        $value = pg_escape_string($value);
        $sql = "SELECT user_id FROM stephen.book_users WHERE $field='$value'";
        $result = pg_query($db, $sql);
        return pg_num_rows($result) != 0;
    }

    $error_msg = '';

    $email = strtolower(trim($_POST['email']));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg .= "Invalid email address.<br>";
    } else if (already_exists($db, 'email', $email)) {
        $error_msg .= "Email address exists.<br>";
    }

    $name = trim($_POST['screen-name']);
    if (strlen($name) == 0 || strlen($name) > 20) {
        $error_msg .= "Screen name must be provided and have at most 20 characters.<br>";
    } else if (already_exists($db, 'name', $name)) {
        $error_msg .= " Screen name already exists.<br>";
    }

    $password = trim($_POST['password']);
    $cpassword = trim($_POST['confirm-password']);
    if (strlen($password) < 10) {
        $error_msg .= "Password must have at least 10 characters.";
    } else if ($password != $cpassword) {
        $error_msg .= "Password fields must match.";
    }

    if ($error_msg == '') {
        // create a new account
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $name = pg_escape_string($name);
        $sql = "INSERT INTO stephen.book_users (user_id, email, name, password) VALUES (default, '$email', '$name', '$hashed_password')";
        $result = pg_query($db, $sql);
        header('Location: ./login.php');
        return;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup Form</title>
    <link href="styles.css" rel="stylesheet">
</head>

<body>
    <div class="menu">
        <main>
            <h1>Books 4 Sale</h1>
            <div class="topnav">
            <a href="index.php">Home</a>
                <a  href="login.php">Login</a>
                <a class="active" href="signup.php">Signup</a>
            </div>
            <hr>

            <div class="menu">
                <section>
                    <img src="https://www.iconpacks.net/icons/2/free-opened-book-icon-3163-thumb.png" alt="coffee icon" />
                    <h2>Signup Form</h2>
                </section>
                <form method="POST" action="./signup.php">
                    <label for="email">Email</label>
                    <br>
                    <input type="text" name="email" id="email" placeholder="youremail@example.com" value="<?php echo $email; ?>">
                    <br>
                    <label for="screen-name">Name</label>
                    <br>
                    <input type="text" id="screen-name" name="screen-name" value="<?php echo $name; ?>">
                    <br>
                    <label for="password">Password</label>
                    <br>
                    <input type="password" name="password" id="password">
                    <br>
                    <label for="confirm-password">Confirm Password</label>
                    <br>
                    <input type="password" name="confirm-password" id="confirm-password">
                    <br>
                    <div class="error"><?php echo '<p class="errors">' . $error_msg . '</p>'; ?></div>
                    <button>Sign Me Up</button>
                </form>
            </div>
    </div>
</body>

</html>