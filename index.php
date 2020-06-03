<?php
	require 'php/conection.php';
	include 'php/functions.php';

	session_start();
	
	if(isset($_SESSION["user_id"])) {
		header("Location: dashboard.php");
	}
	
	$errors = array();
	
	if(!empty($_POST)) {
		$foo = $mysqli->real_escape_string($_POST['foo']);
		$password = $mysqli->real_escape_string($_POST['password']);	
		if(isNullLogin($foo, $password)) {
			$errors[] = "You must complete all the fields";
		}	
		$errors[] = login($foo, $password);	
	}
?>
<html>
	<head>
		<title>Log In</title>		
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>		
	</head>	
	<body>		
		<div class="container">    
			<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
					<div class="panel-heading">
						<div class="panel-title">Log In</div>
						<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="reset_password.php">Forgot your password?</a></div>
					</div>     					
					<div style="padding-top:30px" class="panel-body" >						
						<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>						
						<form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off">							
							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input id="foo" type="text" class="form-control" name="foo" placeholder="Nickname or email address" required>                                        
							</div>							
							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
							</div>							
							<div style="margin-top:10px" class="form-group">
								<div class="col-sm-12 controls">
									<button id="btn-login" type="submit" class="btn btn-success">Log In</a>
								</div>
							</div>							
							<div class="form-group">
								<div class="col-md-12 control">
									<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
										Don`t have an account? <a href="sign_up.php">Sign Up</a>
									</div>
								</div>
							</div>    
						</form>
						<?php echo resultBlock($errors); ?>
					</div>                     
				</div>  
			</div>
		</div>
	</body>
</html>