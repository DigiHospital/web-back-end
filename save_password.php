<?php
	require 'php/conection.php';
	include 'php/functions.php';
	
	$user_id = $mysqli->real_escape_string($_POST['user_id']);
	$token = $mysqli->real_escape_string($_POST['token']);
	$password = $mysqli->real_escape_string($_POST['password']);
	$confirm_password = $mysqli->real_escape_string($_POST['confirm_password']);
	
	if(validatePassword($password, $confirm_password)) {	
		$pass_hash = hashPassword($password);
		if(changePassword($pass_hash, $user_id, $token)) {
			echo "Password modified successfully<br><a href='index.php' >Log In</a>";
		} else {
			echo "Error changing password";
		}
	} else {
		echo 'Passwords don`t match';
	}
?>