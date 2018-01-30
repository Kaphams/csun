<?php
	require "../../../../connection/connection.php";
	session_start();
	
	$emailAddress = $_GET["emailAddress"];
	$Token        = $_GET["Token"];
	
	$stmt = $Connection->prepare("UPDATE users SET Status = 'a', Token = '' WHERE emailAddress = ? AND Token = ?");
	$stmt->bind_param("ss", $emailAddress , $Token);
	$stmt->execute();
	$stmt->close();
	
	$_SESSION["Error"] = "Success! Please authenticate now to access the site.";
	header("Location: /");
	exit;
	
	?>