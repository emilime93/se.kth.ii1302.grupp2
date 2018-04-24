<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DigiBoard</title>
        <link rel="stylesheet" type="text/css" href="resources/css/normalize.css">
        <link rel="stylesheet" type="text/css" href="resources/css/stylesheet.css">
    </head>
    <body>
        <header class="clearfix">
            <a href="index.php">
                <h1 id="logo">DigiBoard</h1>
            </a>
            
            <div id="login-area">
                <form id="login-form" action="controller/user.php" method="POST">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <button type="submit" name="login_btn">Login</button>
                </form>
            </div>
        </header>