<?php
	require $_SERVER['DOCUMENT_ROOT'] . "/account/authenticate.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CSUN - Feed</title>
		<link rel="stylesheet" type="text/css" href="/css/stylesheet.css"><link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<style type="text/css">
			.deletePost {
				text-align: right;
				color:#CCC;
				cursor: pointer;
			}
			iframe {
				display: block;
				margin-top:10px;
			}
		</style>
		<script type="text/javascript">
			function deletePost(ID){
				if(confirm("Are you sure you want to delete this post?")){
					window.location = "deletePost.php?PostID=" + ID;	
				} 
			}
		</script>
	</head>
	<body>
		<?php
				require $_SERVER['DOCUMENT_ROOT'] . "/include/header.php";
				
				if(isset($_SESSION["Message"])){
			?>
				<div style="max-width:1000px; margin:0 auto; padding:10px 0;">
					<div class="Message"><?php echo $_SESSION["Message"]; ?>
					<span style="float:right" onclick="$(this).parent().parent().hide()">X</span>
					</div>
				</div>
			<?php
					unset($_SESSION["Message"]);
				}
				?>
		<div style="max-width:1000px; margin:0 auto; padding:10px 20px;">
			<form method="post" action="uploadPost.php" enctype="multipart/form-data">
				<textarea required max-length="255" name="postContent" style="width:100%; height:70px" placeholder="Share a moment, a thought, or a memory..."></textarea>
				<br>
				<br>
				<input type="submit" value="Post">
				
				<span style="margin-left:20px;">
					Upload a picture, <input type="file" style="border:none" name="Picture">
				</span>
				<br>
				<br>
			</form>
		</div>
		<br>
		<div style="max-width:1000px; margin:0 auto; padding:20px">
			<table style="">
			<?php	
				$stmt = $Connection->prepare("SELECT f.ID, u.ID, f.postText, DATE_FORMAT(f.Created,'%h:%i %m/%d/%y'), u.firstName, u.lastName, p.pictureContent, f.postPicture FROM feed f, users u, pictures p WHERE f.UserID = u.ID AND (p.ID = u.PictureID) ORDER BY f.Created DESC LIMIT 30");
				$stmt->execute();
				$stmt->bind_result($postID, $UserID, $postText, $Created, $firstName, $lastName, $profilePicture, $postPicture);
				while($stmt->fetch()){
			?>
			<tr>
				<td>
					<table style="border-top:solid 1px #CCC; padding-top:10px;">
						<tr>
							<td rowspan="3" style="width:120px; vertical-align:top">
								<?php
									if($profilePicture != "0"){
								?>
								<img class="profilePicture" src="data:image/jpeg;base64,<?php echo base64_encode( $profilePicture ); ?>">
								<?php
									} else {
								?>
								<img class="profilePicture" src="/image/default.png">
								<?php
									}
								?>
							</td>
						</tr>
						<tr>
							<td><a href="/profile/?profile=<?php echo $UserID;?>"><?php echo $firstName; ?> <?php echo $lastName; ?></a></td>
							<td class="deletePost">
								<?php
									if($UserID == $_SESSION["UserID"]){
								?>
								<span onclick="deletePost(<?php echo $postID; ?>);">X</span>
								<?php
								}
								?>
							</td>
						</tr>
						<tr>
							<td style="text-align:left; vertical-align:top;">
									<?php echo $postText; ?>
									<div style="margin-top:5px; font-size:12px; color:#333">Written <?php echo $Created; ?></div>
							</td>
						</tr>
						<?php
							$getPictures = $dualConnection->prepare("SELECT pictureContent FROM pictures WHERE ID = ?");
							$getPictures->bind_param("s",$postPicture);
							$getPictures->execute();
							$getPictures->bind_result($postPictureContent);
							while($getPictures->fetch()){
						?>
						<tr>
							<td colspan="2">	
								<br>
								<img style="width:100%;" src="data:image/jpeg;base64,<?php echo base64_encode( $postPictureContent ); ?>">
							</td>
						</tr>
						<?php
							}
						?>
					</table>	
				</td>
			</tr>
			<?php		
				}
				$stmt->close();	
			?>
			<tr>
				<td style="margin-top:20px; border-top:solid 1px #CCC">&nbsp;</td>
			</tr>
		</table>
		</div>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.js" integrity="sha256-tA8y0XqiwnpwmOIl3SGAcFl2RvxHjA8qp0+1uCGmRmg=" crossorigin="anonymous"></script>
	</body>
</html>
