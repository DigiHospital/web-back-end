<?php
	require 'php/conection.php';
	include 'php/functions.php';

	session_start();

	if (!isset($_SESSION["user_id"])) {
		header("Location: index.php");
	}
	
	$user_id = $_SESSION['user_id'];	
	$sql = "SELECT id, first_name FROM users WHERE id = '$user_id'";
	$result = $mysqli->query($sql);	
	$row = $result->fetch_assoc();
?>

<html>
	<head>
		<title>Dashboard</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>		
		<style>
			body {
				padding-top: 20px;
				padding-bottom: 20px;
			}
		</style>
	</head>	
	<body>
		<div class="container">		
			<nav class='navbar navbar-default'>
				<div class='container-fluid'>
					<div class='navbar-header'>
						<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
							<span class='sr-only'>Dashboard</span>
							<span class='icon-bar'></span>
							<span class='icon-bar'></span>
							<span class='icon-bar'></span>
						</button>
					</div>					
					<div id='navbar' class='navbar-collapse collapse'>
						<ul class='nav navbar-nav'>
							<li class='active'><a href='#'>Dashboard</a></li>			
						</ul>						
						<?php if($_SESSION['user_type'] == 1) { ?>
							<ul class='nav navbar-nav'>
								<li><a href='#'>Manage Users</a></li>
							</ul>
						<?php } ?>						
						<ul class='nav navbar-nav navbar-right'>
							<li><a href='log_out.php'>Log Out</a></li>
						</ul>
					</div>
				</div>
			</nav>				
			<div class="jumbotron">
				<h2><?php echo 'Welcome '.utf8_decode($row['first_name']); ?></h1>
				<br />
			</div>
		</div>
	</body>
</html>