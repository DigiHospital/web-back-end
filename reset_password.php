<?php
	require 'php/conection.php';
	include 'php/functions.php';
	
	session_start();
	
	if (isset($_SESSION["user_id"])) {
		header("Location: dashboard.php");
	}
	
	$errors = array();
	
	if (!empty($_POST)) {
		$email = $mysqli->real_escape_string($_POST['email']);		
		if(!isEmail($email)) {
			$errors[] = "You must input a valid email address";
		}	
		if(emailExists($email)) {
			$user_id = getValue('id', 'email', $email);
			$first_name = getValue('first_name', 'email', $email);			
			$token = generateTokenPassword($user_id);			
			$url = 'http://'.$_SERVER["SERVER_NAME"].'/projects/php/login/change_password.php?user_id='.$user_id.'&token='.$token;			
			$subject = 'Reset Password - Users System';
			$body = "Hi $first_name! <br /><br />You requested a password reset. <br/><br/>To complete the process please click the following link: <a href='$url'>CHANGE PASSWORD</a>";			
			if (sendEmail($email, $first_name, $subject, $body)) {
				echo "We`ve sent an email to the address '$email' to reset your password.<br />";
				echo "<a href='index.php'>Log In</a>";
				exit;
			}
		} else {
			$errors[] = "Email address doesn`t exists";
		}
	}
?>
<html>
	<head>
		<title>Reset Password</title>
		
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>
	</head>
	
	<body>
		
		<div class="container">    
			<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
				<div class="panel panel-info" >
					<div class="panel-heading">
						<div class="panel-title">Reset Password</div>
						<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="index.php">Log In</a></div>
					</div>     
					
					<div style="padding-top:30px" class="panel-body" >
						
						<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
						
						<form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
							
							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input id="email" type="email" class="form-control" name="email" placeholder="Email address" required>                                        
							</div>
							
							<div style="margin-top:10px" class="form-group">
								<div class="col-sm-12 controls">
									<button id="btn-login" type="submit" class="btn btn-success">Reset</a>
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