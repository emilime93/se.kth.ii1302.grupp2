<?php
// echo($_POST['username']);
echo $_SERVER['REQUEST_URI'];


if (isset($_POST['login_btn'])) {
    UserController.register_user();
    echo("Login");
} elseif(isset($_POST['register_btn'])) {
    echo("Register");
} else {
    echo("Other");
}

class UserController {
    
    public function register_user() {
        echo("Register user " . $_POST['username'] . " with password " . $_POST['password']);
    }

    public function login_user() {
        echo("Login in user " . $_POST['username'] . " with password " . $_POST['password']);
    }

}