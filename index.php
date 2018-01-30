<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>CSUN Social Network - Please Login</title>
		<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		<style type="text/css">
			* {
				font-family: 'Montserrat';
			}
			body {
				margin: 0;
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
			input[type="email"], input[type="password"] {
				padding: 5px;
				font-size: 16px;
				box-sizing: border-box;
			}
			#loginForm {
				width:400px;
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
			#Banner {
				background: #333;
				color:#FFF;
				text-align: center;
				padding: 10px 0;
			}
		</style>
	</head>
	<body>
		<div id="Banner">
			This site is not affiliated, maintained or owned by California State University, Northridge.
		</div>
		<br>
		<br>
		<br>
		<form id="loginForm" method="post" action="/account/signin.php">
			<img src="/image/logo.png" style="display:inline; width:100%">
			<br>
			<br>
			
			<?php
				if(isset($_SESSION["Error"])){
					echo "<p><b>" . $_SESSION["Error"] . "</b></p>";
					unset($_SESSION["Error"]);
				}	
			?>
			
			<p style="padding:10px 0; border-top:solid 1px #DDD; border-bottom:solid 1px #DDD;">
				Login to access the CSUN social networking site.
			</p>
			<label for="emailAddress">Email Address</label>
			<input type="email" id="emailAddress" name="emailAddress" placeholder="Email Address" required>
			<label for="Password">Password</label>
			<input type="password" id="Password" name="Password" placeholder="Password" required>
			<input type="submit" value="Sign In" class="button">
			<a href="">Trouble logging in?</a>
		</form>
		<br>
		<div style="width:320px; border-top:solid 1px crimson; display:block; margin:0 auto; padding-top:20px;">
			Don't have an account yet? <a href="/account/sign-up/">Sign up.</a>
		</div>
	</body>
</html>