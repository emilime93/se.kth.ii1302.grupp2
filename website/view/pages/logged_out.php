<main class="clearfix">
		<h1>Welcome to DigiBoards site</h1>
		<section>
			<h2>Messages</h2>
			<p>Welcome to out amazing site.</p>
		</section>
		<section>
			<h2>Register</h2>
			<form id="registry-form" action="../../controller/user_controller.php" method="POST">
				<input type="text" name="fname" placeholder="Firstname">
			    <input type="text" name="lname" placeholder="Lastname">
			    <input type="text" name="username" placeholder="Username">
			    <input type="text" name="signup_code" placeholder="Signup Code">
			    <input type="email" name="email" placeholder="E-mail">
			    <input type="password" name="password" placeholder="Password">
			    <button type="submit" name="button" value="register">Signup</button>
				<?php 
				if (isset($_SESSION['register_success'])) {
					if ($_SESSION['register_success']) {
						echo '<p class="success">You are now registered!</p>';
					} else {
						echo '<p class="error">Registration failed!</p>';
					}
					unset($_SESSION['register_success']);
				}
				?>
       </form>
		</section>
	
</main>