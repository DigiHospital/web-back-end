<?php
	require 'php/conection.php';
	include 'php/functions.php';

	session_start();
	
	if (empty($_GET['user_id'])) {
		header('Location: index.php');
	}
	
	if (empty($_GET['token'])) {
		header('Location: index.php');
	}
	
	$user_id = $mysqli->real_escape_string($_GET['user_id']);
	$token = $mysqli->real_escape_string($_GET['token']);
	
	if(!verifyTokenPassword($user_id, $token)) {
		echo 'Data could not be verified';
		exit;
	} 
?>
<html>
	<head>
		<title>Change Password</title>		
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>		
	</head>	
	<body>		
		<div class="container">    
			<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-7 col-md-offset-2 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
					<div class="panel-heading">
						<div class="panel-title">Change Password</div>
						<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="index.php">Log In</a></div>
					</div>     					
					<div style="padding-top:30px" class="panel-body" >						
						<form id="loginform" class="form-horizontal" role="form" action="save_password.php" method="POST" autocomplete="off">							
							<input type="hidden" id="user_id" name="user_id" value ="<?php echo $user_id; ?>" />							
							<input type="hidden" id="token" name="token" value ="<?php echo $token; ?>" />							
							<div class="form-group">
								<label for="password" class="col-md-3 control-label">New Password</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="password" placeholder="New Password" required>
								</div>
							</div>							
							<div class="form-group">
								<label for="confirm_password" class="col-md-3 control-label">Confirm Password</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
								</div>
							</div>							
							<div style="margin-top:10px" class="form-group">
								<div class="col-sm-12 controls">
									<button id="btn-login" type="submit" class="btn btn-success">Change</a>
								</div>
							</div>   
						</form>
					</div>                     
				</div>  
			</div>
		</div>
	</body>
</html>