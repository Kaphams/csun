<?php
	require $_SERVER['DOCUMENT_ROOT'] . "/../connection/connection.php";
	
	session_start();
	
	//Check if email and token are set in the session.
	if(!isset($_SESSION["emailAddress"]) || !isset($_SESSION["Token"])){
		$_SESSION["Error"] = "Please login to access the site.";
		header("Location: /");
		exit;
	}

	$UserID       = $_SESSION["UserID"];
	$emailAddress = $_SESSION["emailAddress"];
	$Token        = $_SESSION["Token"];
	
	$stmt = $Connection->prepare("SELECT Expiration FROM sessions WHERE emailAddress = ? AND Token = ?");
	$stmt->bind_param("ss", $emailAddress, $Token);
	$stmt->execute();
	$stmt->bind_result($Expiration);
	$stmt->fetch();
	$stmt->close();	

	//Not token was found or was revoked, redirect to login page.
	if($Expiration == ""){
		$_SESSION["Error"] = "Please login to access the site.";
		header("Location: /");
		exit;
	}
?>