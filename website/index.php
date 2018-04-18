<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DigiBoard</title>
    <link rel="stylesheet" type="text/css" href="resources/stylesheet.css">
</head>
<body>
	<div id="header">
		<a href="index.html"><img class="logo" alt="logo" src="https://cdn.dribbble.com/users/77598/screenshots/2404454/oppa.jpg"/></a>
		<div id="login">
			<form action="controller/user.php" method="POST">
					<input type="text" name="username" placeholder="Username">
					<input type="password" name="password" placeholder="password">
					<button type="submit" name="login_btn">Login</button>
			</form>
		</div>
	</div>
	<div id="main">
		<h1>Welcome to DigiBoards site</h1>
		<div class="section1">
			<h1>Messages</h1>
			<div class='comment-box'>
				<p>
					<p class='user-date'><br>Kalle</p>
					2018-04-13 10:30 <br> Inte på kontoret
				</p>
			</div>
			<div class='comment-box'>
							<p>
								<p class='user-date'><br>Olle</p>
								2018-04-10 18:05 <br> På semester!!!
							</p>
			</div>
		</div>
		<div class="section2">
			<h1>Register</h1>
			<form action="controller/user.php" method="POST">
				<input type="text" name="first" placeholder="Firstname">
			    <input type="text" name="last" placeholder="Lastname">
			    <input type="text" name="username" placeholder="Username">
			    <input type="text" name="signup_code" placeholder="Signup Code">
			    <input type="email" name="email" placeholder="E-mail">
			    <input type="password" name="password" placeholder="Password">
			    <button type="submit" name="register_btn">Signup</button>
           	</form>
		</div>
    </div>
</body>
</html>