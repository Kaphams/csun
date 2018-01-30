<?php
	require $_SERVER['DOCUMENT_ROOT'] . "/account/authenticate.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CSUN - Settings</title>
		<link rel="stylesheet" type="text/css" href="/css/stylesheet.css"><link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<style type="text/css">
			main {
				padding:0 20px;
			}
			input[type="file"] {
				border:none;
			}
		</style>
	</head>
	<body>
		<?php
			require $_SERVER['DOCUMENT_ROOT'] . "/include/header.php";
		
		?>
		<main>
			<h1>Settings</h1>
			<fieldset>
				<legend>Profile Picture</legend>
				<form method="post" action="updateProfilePicture.php" enctype="multipart/form-data">
					<table>
					<?php	
					$stmt = $Connection->prepare("SELECT p.pictureContent FROM users u, pictures p WHERE u.ID = ? AND p.ID = u.PictureID");
					$stmt->bind_param("s",$UserID);
					$stmt->execute();
					$stmt->bind_result($pictureContent);
					$stmt->fetch();
					$stmt->close();
					?>
						<tr>
							<td rowspan="4"><img class="profilePicture" src="data:image/jpeg;base64,<?php echo base64_encode( $pictureContent ); ?>"></td>
						</tr>
						<tr>
							<td><b>Upload a new profile picture</b></td>
						</tr>
						<tr>
							<td><input type="file" name="Picture"></td>
						</tr>
						<tr>
							<td><input type="submit" value="Save"></td>
						</tr>
					</table>
				</form>
			</fieldset>
			<br>
			<fieldset>
				<legend>Update Headline</legend>
				<form method="post" action="updateHeadline.php">
				<?php	
					$stmt = $Connection->prepare("SELECT About FROM users WHERE ID = ?");
					$stmt->bind_param("s",$UserID);
					$stmt->execute();
					$stmt->bind_result($Headline);
					$stmt->fetch();
				?>
				<textarea style="width:100%;" name="Headline"><?php echo $Headline; ?></textarea>
				<br>
				<br>
				<input type="submit" value="Save">
			</fieldset>
			
			<script src="https://code.jquery.com/jquery-3.2.1.slim.js" integrity="sha256-tA8y0XqiwnpwmOIl3SGAcFl2RvxHjA8qp0+1uCGmRmg=" crossorigin="anonymous"></script>
		</main>
	</body>
</html>
