<?php
	require $_SERVER['DOCUMENT_ROOT'] . "/account/authenticate.php";
	
	$UserID = $_SESSION["UserID"];

	$stmt = $Connection->prepare("UPDATE users SET About = ? WHERE ID = ?");
	$stmt->bind_param("ss", $_POST["Headline"], $UserID);
	$stmt->execute();
	$stmt->close();
	
	header("Location: /account/settings/");
	exit;
?>	