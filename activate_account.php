<?php
	require 'php/conection.php';
	include 'php/functions.php';
	
	if (isset($_GET["user_id"]) AND isset($_GET['token'])) {	
		$user_id = $_GET['user_id'];
		$token = $_GET['token'];		
		$message = validateIdToken($user_id, $token);
	}
?>
<html>
	<head>
		<title>Activate Account</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>
		
	</head>
	
	<body>
		<div class="container">
			<div class="jumbotron">
				
				<h1><?php echo $message; ?></h1>
				
				<br />
				<p><a class="btn btn-primary btn-lg" href="index.php" role="button">Log In</a></p>
			</div>
		</div>
	</body>
</html>