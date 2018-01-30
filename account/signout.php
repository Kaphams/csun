<?php
	require "../../connection/connection.php";

	session_start();	

	$Token = $_SESSION["Token"];

	$stmt = $Connection->prepare("DELETE From sessions WHERE Token = ?");
	$stmt->bind_param("s", $Token);
	$stmt->execute();
	$stmt->close();
	
	//Successful login, redirect to newsfeed by default.
	session_unset();
	
	$_SESSION["Error"] = "You have been successfully signed out.";
	header("Location: /");
?>







	
