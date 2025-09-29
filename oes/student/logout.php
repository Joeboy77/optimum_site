<?php
session_start();
require '../../config.php';
error_reporting(0);

if (isset($_POST["logout_btn"])) {
	# code...
	session_destroy();
	unset($_SESSION['id']);
	header('location: ../index.php');
}

?>
