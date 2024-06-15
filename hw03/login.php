<?php
$db = pg_connect("host=csci.hsutx.edu dbname=web2db user=web2 password=welovethisclass");

if (!$db) {
    header("Location: error.php?error=db_connect");
    return;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="styles.css" rel="stylesheet">
</head>

<body>
    <div class="menu">
        <main>
            <h1>Books 4 Sale</h1>
            <div class="topnav">
                <a href="index.php">Home</a>
                <a href="addbook.php">Add Book</a>
                <a class="active" href="login.php">Login</a>
            </div>
            <hr>
            <div class="menu">
                <h1>Move along. Nothing to see here</h1>
                <img        style="display: block;
                            margin-left: auto;
                            margin-right: auto;
                            margin-top: -25;
                            max-width: 50%;
                            max-height: 50%;" 
                            class="loginicon" 
                            src="https://cdn.7tv.app/emote/650f11b8c9920b628417b4ec/4x.png" 
                            alt="xddbusines">
            </div>
    </div>
</body>