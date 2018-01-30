<?php
	require $_SERVER['DOCUMENT_ROOT'] . "/account/authenticate.php";
	
	$UserID      = $_SESSION["UserID"];
	$postContent = $_POST["postContent"];
	$Created     = date("Y-m-d H:i:s");	
	$postContent = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $postContent);
	
	//See if user included a photo with their post.
	if(file_exists($_FILES['Picture']['tmp_name']) || is_uploaded_file($_FILES['Picture']['tmp_name'])) {
		
		$info = getimagesize($_FILES['Picture']['tmp_name']);
		if ($info === FALSE) {
			$_SESSION["Error"] = "Please check your upload, it does not appear to be an image.";
		    header("Location: /feed/");
			exit;
		}
		
		if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
			$_SESSION["Error"] = "Only jpgs, pngs, and gifs are allowed.";
			header("Location: /feed/");
			exit;
		}
		
		$defaultPicture = file_get_contents($_FILES['Picture']['tmp_name']);
			
		$stmt = $Connection->prepare("INSERT INTO pictures (UserID, pictureContent, Created) VALUES (?,?,?)");
		$stmt->bind_param("sss", $UserID, $defaultPicture, $Created);
		$stmt->execute();
		$PictureID = $Connection->insert_id;
		$stmt->close();
		
		$stmt = $Connection->prepare("INSERT INTO feed (UserID, postText, Created, postPicture) VALUES (?,?,?,?)");
		$stmt->bind_param("ssss", $UserID, $postContent, $Created, $PictureID);
		$stmt->execute();
		echo $Connection->error;
	} else {
			$stmt = $Connection->prepare("INSERT INTO feed (UserID, postText, Created) VALUES (?,?,?)");
			$stmt->bind_param("sss", $UserID, $postContent, $Created);
			$stmt->execute();
			echo $Connection->error;
	}

	header("Location: /feed/");
?>







	
