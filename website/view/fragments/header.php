<php? session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>DigiBoard</title>
        <link rel="stylesheet" type="text/css" href="resources/css/normalize.css">
        <link rel="stylesheet" type="text/css" href="resources/css/stylesheet.css">
    </head>
    <body>
        <div id="header">
            <a href="index.html"><img class="logo" alt="logo" src="../../resources/img/oppa.jpg"/></a>
            <div id="login">
                <form action="controller/user.php" method="POST">
                        <input type="text" name="username" placeholder="Username">
                        <input type="password" name="password" placeholder="password">
                        <button type="submit" name="login_btn">Login</button>
                </form>
            </div>
        </div>