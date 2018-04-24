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