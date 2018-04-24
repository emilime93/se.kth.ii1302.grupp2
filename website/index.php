<?php
include("view/fragments/header.php");
if(isset($_SESSION['logged_in_user'])) {
	include("view/pages/logged_in.php");
} else {
	include("view/pages/logged_out.php");
}
include("view/fragments/footer.php");