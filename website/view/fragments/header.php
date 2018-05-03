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
				<?php if (isset($_SESSION['logged_in_user'])) { 
				
					require_once($_SERVER['DOCUMENT_ROOT'].'/model/user_model.php');
					$user_model = unserialize($_SESSION['logged_in_user']);
					$username = $user_model->get_username();
					echo  "Logged in as " . $username;
					echo '<form id="logout_form" action="util/post_handler.php" method="POST">';
					echo '	<button type="submit" name="submit" value="logout">Log out</button>';
					echo '</form>';
					
				} else { ?>
				
					<form id="login-form" action="util/post_handler.php" method="POST">
						<input type="text" name="username" placeholder="Username">
						<input type="password" name="password" placeholder="Password">
						<button type="submit" name="submit" value="login">Login</button>
					</form>
					
					<?php if (isset($_SESSION['login_failed'])) {
						echo '<p class="error">Login failed!</p>';
						unset($_SESSION['login_failed']);
					}
				} ?>
            </div>
        </header>