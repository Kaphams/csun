<?php
	require $_SERVER['DOCUMENT_ROOT'] . "/account/authenticate.php";
	if(isset($_GET["profile"])){
		$UserID = $_GET["profile"];
	} else {
		$UserID = $_SESSION["UserID"];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CSUN - Profile</title>
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
			.profilePicture {
				width:200px !IMPORTANT;
			}
		</style>
		<script type="text/javascript">
		
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
	
				$stmt = $Connection->prepare("SELECT u.firstName, u.lastName, u.about, p.pictureContent FROM users u, pictures p WHERE u.ID = ? AND (p.ID = u.PictureID)");
				echo $Connection->error;
				$stmt->bind_param("s",$UserID);
				$stmt->execute();
				$stmt->bind_result($firstName, $lastName, $Headline, $profilePicture);
				$stmt->fetch();
				$stmt->close();
			?>
		<div style="max-width:1000px; margin:0 auto; padding:10px 20px;">
			<h1 style="margin:0; text-align:center;"><?php echo $firstName; echo " " . $lastName; ?>'s Profile</h1>
			<table style="width:0; margin:0 auto;">
				<tr>
					<td>
			<?php
				if($profilePicture != "0"){
			?>
			<img class="profilePicture" style="border:solid 1px crimson" src="data:image/jpeg;base64,<?php echo base64_encode( $profilePicture ); ?>">
			<?php
				} else {
			?>
			<img class="profilePicture" style="border:solid 1px crimson"  src="/image/default.png">
			<?php
				}
				?>
				</td>
				<td style="text-align:left; padding-left:20px">
					Headline
					<br>
					"<span style="color:#888;"><i><?php echo $Headline; ?></i></span>"
					<?php
						if($UserID == $_SESSION["UserID"]){
							echo "<br><a href='/account/settings/' style='font-size:12px'>Edit</a>";
						}
					?>
				</td>
			</tr>
		</div>
		<div style="max-width:1000px; margin:0 auto; padding:20px">
			<table style="">
			<?php	
				$stmt = $Connection->prepare("SELECT postText, DATE_FORMAT(Created,'%h:%i %m/%d/%y'), postPicture FROM feed f WHERE UserID = ? ORDER BY Created DESC LIMIT 30");
				echo $Connection->error;
				$stmt->bind_param("s", $UserID);
				$stmt->execute();
				$stmt->bind_result($postText, $Created, $postPicture);
				while($stmt->fetch()){
			?>
			<tr>
				<td>
					<table style="border-top:solid 1px #CCC; padding-top:10px;">
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
