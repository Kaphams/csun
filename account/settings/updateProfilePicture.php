<?php
	require $_SERVER['DOCUMENT_ROOT'] . "/account/authenticate.php";
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
			
		//Your Image
		$imgSrc = $_FILES['Picture']['tmp_name'];
		
		//getting the image dimensions
		list($width, $height) = getimagesize($imgSrc);
		
		//saving the image into memory (for manipulation with GD Library)
		if($info[2] == IMAGETYPE_JPEG){
			$myImage = imagecreatefromjpeg($imgSrc);
		}
		if($info[2] == IMAGETYPE_PNG) {
			$myImage = imagecreatefrompng($imgSrc);
		}
		
		// calculating the part of the image to use for thumbnail
		if ($width > $height) {
			$y = 0;
			$x = ($width - $height) / 2;
			$smallestSide = $height;
		} else {
			$x = 0;
			$y = ($height - $width) / 2;
			$smallestSide = $width;
		}
		
		// copying the part into thumbnail
		$thumbSize = 350;
		$thumb = imagecreatetruecolor($thumbSize, $thumbSize);
		imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);
		
		//final output
		ob_start(); 
		imagejpeg($thumb);
		$pictureContent = ob_get_clean();
		
		$stmt = $Connection->prepare("SELECT pictureID FROM users WHERE ID = ?");
		$stmt->bind_param("s", $UserID);
		$stmt->execute();
		$stmt->bind_result($pictureID);
		$stmt->fetch();
		$stmt->close();
		
		$stmt = $Connection->prepare("UPDATE pictures SET pictureContent = ? WHERE ID = ?");
		$stmt->bind_param("ss", $pictureContent, $pictureID);
		$stmt->execute();
		$stmt->close();
	}
	
	header("Location: /account/settings/");
	exit;
?>	