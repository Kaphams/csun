<?php
	require $_SERVER['DOCUMENT_ROOT'] . "/account/authenticate.php";
	
	$UserID = $_SESSION["UserID"];
	$PostID = $_GET["PostID"];
	
	$stmt = $Connection->prepare("DELETE FROM feed WHERE UserID = ? AND ID = ?");
	$stmt->bind_param("ss", $UserID, $PostID);
	$stmt->execute();
	echo $Connection->error;
	
	$_SESSION["Message"] = "Post was successfully removed.";
	header("Location: /feed/");
?>







	
