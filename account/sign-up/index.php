<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>CSUN Social Network - Sign Up</title>
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<style type="text/css">
			* {
				font-family: 'Montserrat';
			}
			a {
				color:crimson;
				text-decoration: none;
			}
			a:hover {
				text-decoration: underline;
			}
			body {
				background: #FFF;
			}
			input[type="email"], input[type="password"], input[type="text"] {
				padding: 5px;
				font-size: 16px;
				box-sizing: border-box;
			}
			#loginForm {
				max-width:400px;
				margin: 0 auto;
			}
			#loginForm input {
				display: block;
				width: 100%;
				margin: 15px 0;
			}
			.button {
				border:none;
				padding: 10px 0;
				color:#FFF;
				font-size: 16px;
				background: crimson;	
			}	
			.button:hover {
				cursor: pointer;
				background: #DDD;
				color:#000;
				text-decoration: underline;
			}	
		</style>
	</head>
	<body>
		<br>
		<br>
		<form id="loginForm" method="post" action="/account/signup.php">
			<img src="/image/logo.png" style="display:inline; width:100%">
			<br>
			<br>
			
			<?php
				if(isset($_SESSION["Error"])){
					echo "<p><b>" . $_SESSION["Error"] . "</b></p>";
					unset($_SESSION["Error"]);
				}	
			?>
			<h1>Sign Up</h1>
			<p style="padding:10px 0; border-top:solid 1px #DDD; border-bottom:solid 1px #DDD;">
				Please enter your CSUN email and information below.
			</p>
			<label for="emailAddress">CSUN Email Address</label>
			<input type="email" id="emailAddress" name="emailAddress" placeholder="CSUN Email Address" required>
			<table style="padding:0; margin:0; border-collapse:collapse;">
				<tr>
					<td style="padding:0;"><label for="firstName">First Name</label></td>
					<td style="padding:0;"><label for="lastName">Last Name</label></td>
				</tr>
				<tr>
					<td style="padding:0;">
						<input type="text" id="firstName" name="firstName" placeholder="First Name" required>
					</td>
					<td style="padding:0;">
						<input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
					</td>
				</tr>
			</table>
			<label for="Password">Password (8 Characters Min.)</label>
			<input type="password" id="Password" name="Password" placeholder="Choose a Password" required>
			<input type="submit" value="Sign Up" class="button">
		</form>
		<br>
		<div style="width:320px; text-align:center; border-top:solid 1px crimson; display:block; margin:0 auto; padding-top:20px;">
			Already have an account? <a href="/">Sign in.</a>
		</div>
	</body>
</html>