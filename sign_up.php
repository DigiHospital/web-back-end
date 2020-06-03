<?php
	require 'php/conection.php';
	include 'php/functions.php';

	$errors = array();
	
	if (!empty($_POST)) {
		
		$nickname = $mysqli->real_escape_string($_POST['nickname']);
		$first_name = $mysqli->real_escape_string($_POST['first_name']);
		$last_name = $mysqli->real_escape_string($_POST['last_name']);
		$address = $mysqli->real_escape_string($_POST['address']);
		$phone = $mysqli->real_escape_string($_POST['phone']);
		$password = $mysqli->real_escape_string($_POST['password']);
		$confirm_password = $mysqli->real_escape_string($_POST['confirm_password']);
		$email = $mysqli->real_escape_string($_POST['email']);
		$captcha = $mysqli->real_escape_string($_POST['g-recaptcha-response']);
		$active = 0;
		$user_type = 2;
		$secret = '6LcUDfgUAAAAAPfPNvQVISBbuTMSH7X4okP9b66a';
		
		if(!$captcha) {
			$errors[] = "Please verify the captcha";
		}
		
		if (isNull($first_name, $last_name, $nickname, $password, $confirm_password, $email)) {
			$errors[] = "You must complete all the fields";
		}
		
		if(!isEmail($email)) {
			$errors[] = "Invalid email address";
		}
		
		if(!validatePassword($password, $confirm_password)) {
			$errors[] = "Passwords don`t match";
		}		
		
		if(nicknameExists($nickname)) {
			$errors[] = "Nickname '$nickname' already exists";
		}
		
		if(emailExists($email)) {
			$errors[] = "Email address '$email' already exists";
		}
		
		if(count($errors) == 0) {	
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");			
			$arr = json_decode($response, TRUE);
			if($arr['success']) {	
				$pass_hash = hashPassword($password);
				$token = generateToken();				
				$user_id = registerUser($nickname, $pass_hash, $first_name, $last_name, $address, $phone, $email, $active, $token, $user_type);
				if($user_id > 0) {		
					$url = 'http://'.$_SERVER["SERVER_NAME"].'/projects/php/login/activate_account.php?user_id='.$user_id.'&token='.$token;					
					$subject = 'Activate Account - Users System';
					$body = "Hi $first_name! <br /><br />To continue with the sign up process, please click on the following link <a href='$url'>ACTIVATE ACCOUNT</a>";	
					if(sendEmail($email, $first_name, $subject, $body)){						
						echo "In order to complete the sign up process, please follow the instructions we`ve sent you to the following email address: $email";
						echo "<br><a href='index.php'>Log In</a>";
						exit;
					} else {
						$errors[] = "Error on sending email";
					}	
				} else {
					$errors[] = "Error on register";
				}	
			} else {
				$errors[] = 'Error on reCaptcha validation';
			}
		}

	}	
?>
<html>
	<head>
		<title>Sign Up</title>
		
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>	
	<body>
		<div class="container">
			<div id="signupbox" style="margin-top:50px" class="mainbox col-md-7 col-md-offset-2 col-sm-8 col-sm-offset-2">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="panel-title">Sign Up</div>
						<div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="index.php">Log In</a></div>
					</div>  					
					<div class="panel-body" >
						<form id="signupform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">							
							<div id="signupalert" style="display:none" class="alert alert-danger">
								<p>Error:</p>
								<span></span>
							</div>
							<div class="form-group">
								<label for="nickname" class="col-md-3 control-label">Nickname:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="nickname" placeholder="Nickname" value="<?php if(isset($nickname)) echo $nickname; ?>" required>
								</div>
							</div>											
							<div class="form-group">
								<label for="first_name" class="col-md-3 control-label">First Name:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="first_name" placeholder="First Name" value="<?php if(isset($first_name)) echo $first_name; ?>" required >
								</div>
							</div>
							<div class="form-group">
								<label for="last_name" class="col-md-3 control-label">Last Name:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="last_name" placeholder="Last Name" value="<?php if(isset($last_name)) echo $last_name; ?>" required >
								</div>
							</div>
							<div class="form-group">
								<label for="address" class="col-md-3 control-label">Address:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="address" placeholder="Address" value="<?php if(isset($address)) echo $address; ?>" required >
								</div>
							</div>
							<div class="form-group">
								<label for="phone" class="col-md-3 control-label">Phone:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php if(isset($phone)) echo $phone; ?>" required >
								</div>
							</div>					
							<div class="form-group">
								<label for="password" class="col-md-3 control-label">Password:</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="password" placeholder="Password" required>
								</div>
							</div>							
							<div class="form-group">
								<label for="confirm_password" class="col-md-3 control-label">Confirm Password:</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
								</div>
							</div>							
							<div class="form-group">
								<label for="email" class="col-md-3 control-label">Email Address:</label>
								<div class="col-md-9">
									<input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php if(isset($email)) echo $email; ?>" required>
								</div>
							</div>							
							<div class="form-group">
								<label for="captcha" class="col-md-3 control-label"></label>
								<div class="g-recaptcha col-md-9" data-sitekey="6LcUDfgUAAAAAIj52ZS83CG6-PxrJcpCO3vjfYtt"></div>
							</div>							
							<div class="form-group">                             
								<div class="col-md-offset-5 col-md-7">
									<button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Sign Up</button> 
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