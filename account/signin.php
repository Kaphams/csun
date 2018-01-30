<?php
	require "../../connection/connection.php";

	session_start();	

	$emailAddress = $_POST["emailAddress"];
	$Password     = $_POST["Password"];	

	if($emailAddress == ""){
		$_SESSION["Error"] = "Please enter an email address.";
		header("Location: /");
		exit;
	} 
	
	if($Password == ""){
		$_SESSION["Error"] = "Please enter a password.";
		header("Location: /");
		exit;
	}
	
	$stmt = $Connection->prepare("SELECT ID, Password, Status FROM users WHERE emailAddress = ?");
	echo $Connection->error;
	$stmt->bind_param("s", $emailAddress);
	$stmt->execute();
	$stmt->bind_result($UserID, $foundPassword, $Status);
	$stmt->fetch();
	
	//No user was even found with the entered email.
	if($UserID == ""){
		$_SESSION["Error"] = "Incorrect username/password combination.";
		header("Location: /");
		exit;
	}
	$stmt->close();	

	if($Status == "u"){
		$_SESSION["Error"] = "Please click the link in the verification email sent to you before logging in.";
		header("Location: /");
		exit;
	}
	
	//User account found, but password does not match what is in database.
	if(!password_verify($Password,$foundPassword)){
		$_SESSION["Error"] = "Incorrect username/password combination.";
		header("Location: /");
		exit;
	}
	
	//Create a secure token that is stored in the session, also store an expiration time.
	$Token      = bin2hex(random_bytes(16));
	$Expiration = date("Y-m-d H:i:s",strtotime("+30 minutes"));	

	$stmt = $Connection->prepare("INSERT INTO sessions (emailAddress, Token, Expiration) VALUES (?,?,?)");
	echo $Connection->error;
	$stmt->bind_param("sss", $emailAddress, $Token, $Expiration);
	$stmt->execute();
	$stmt->close();

	$_SESSION["UserID"]       = $UserID;
	$_SESSION["emailAddress"] = $emailAddress;
	$_SESSION["Token"]        = $Token;
	
	//Successful login, redirect to newsfeed by default.
	header("Location: /feed/");
?>







	
