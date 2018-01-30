<?php
	require "../../connection/connection.php";
	session_start();
	
	$emailAddress = strtolower($_POST["emailAddress"]);
	$firstName    = $_POST["firstName"];
	$lastName     = $_POST["lastName"];
	$Password     = $_POST["Password"];
	
	//Make sure email address is valid
	if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
    	$_SESSION["Error"] = "Please enter a valid email address";
		header("Location: /account/sign-up/");
		exit;
	}
	
	if($firstName == ""){
		$_SESSION["Error"] = "Please enter your first name.";
		header("Location: /account/sign-up/");
		exit;
	}
	
	if($lastName == ""){
		$_SESSION["Error"] = "Please enter your last name.";
		header("Location: /account/sign-up/");
		exit;
	}
	
	if($Password == ""){
		$_SESSION["Error"] = "Please enter a password";
		header("Location: /account/sign-up/");
		exit;
	}
	
	if(strlen($Password) < 8){
		$_SESSION["Error"] = "Please enter a password that is at least 8 characters long.";
		header("Location: /account/sign-up/");
		exit;
	}
	
	//Make sure email address is a my.csun.edu address
	$domainName = substr(strrchr($emailAddress, "@"), 1);
	if($domainName != "my.csun.edu"){
		$_SESSION["Error"] = "You must register with a <span style='color:crimson'>my.csun.edu</span> email address to access the site.";
		header("Location: /account/sign-up/");
		exit;
	}
	
	//Check database and make sure that this email doesn't already exist.
	$stmt = $Connection->prepare("SELECT ID FROM users WHERE emailAddress = ?");
	echo $Connection->error;
	$stmt->bind_param("s", $emailAddress);
	$stmt->execute();
	$stmt->bind_result($foundUser);
	$stmt->fetch();
	
	if($foundUser != ""){
		$_SESSION["Error"] = "We're sorry, that email address is already in use.";
		header("Location: /account/sign-up/");
		exit;
	}
	
	require "../lib/phpMailer/PHPMailer.php";
	require "../lib/phpMailer/SMTP.php";
	require "../lib/phpMailer/Exception.php";
		
	use PHPMailer\PHPMailer\PHPMailer;
	
	//Sign up token for email verification
	$Token = bin2hex(random_bytes(16));
	
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = '	email-smtp.us-west-2.amazonaws.com';
	$mail->Port = 587;
	$mail->SMTPAuth = true;
	$mail->Username = 'AKIAI6XXUJTA53FI3CFA';
	$mail->Password = 'AkJ3t7Oq69yWAl/pz9HRF90bVKtRS8Zrh/d4NG4nEbg1';
	$mail->setFrom('noreply@csun.online', 'csun.online');
	$mail->Subject = 'csun.online - Finish Account Setup';
	$mail->addAddress($emailAddress, $firstName . " " . $lastName);
	$mail->msgHTML("Please click the link below to verify your account.<br><br><a href='https://csun.online/account/sign-up/complete/?emailAddress=$emailAddress&Token=$Token'>Complete Account Setup</a>");
	
	if (!$mail->send()) {
		$_SESSION["Error"] = "An error occured, please try again later";
	    header("Location: /sign-up/");
	}
	
	//Hash password
	$Password = password_hash($Password, PASSWORD_DEFAULT);
	
	//All checks passed, insert user into database and redirect.
	$stmt = $Connection->prepare("INSERT INTO users (emailAddress, firstName, lastName, Password, Token, About, Status) VALUES (?,?,?,?,?,'Just living my best life at CSUN!','u')");
	echo $Connection->error . 'test';
	$stmt->bind_param("sssss", $emailAddress, $firstName, $lastName, $Password, $Token);
	$stmt->execute();
	$UserID =  $_SESSION["UserID"] = $Connection->insert_id;
	$stmt->close();

	$Created      = date("Y-m-d H:i:s");	
	
	//Create default profile picture
	$defaultPicture = file_get_contents("../image/default.png");
	
	$stmt = $Connection->prepare("INSERT INTO pictures (UserID, pictureContent, Created) VALUES (?,?,?)");
	$stmt->bind_param("sss", $UserID, $defaultPicture, $Created);
	$stmt->execute();
	$PictureID = $Connection->insert_id;
	$stmt->close();
	
	$stmt = $Connection->prepare("UPDATE users SET PictureID = ? WHERE ID = ?");
	$stmt->bind_param("ss", $PictureID, $UserID);
	$stmt->execute();
	$PictureID = $Connection->insert_id;
	$stmt->close();
	
	header("Location: /account/sign-up/verify/");
	exit;
	
?>