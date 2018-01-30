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
			This site is not affialted, maintained or owned by California State University, Northridge.
		</div>
		<br>
		<br>
		<br>
		<form id="loginForm">
			<img src="/image/logo.png" style="display:inline; width:100%">
			<br>
			<br>
			<br>
			<b>Please check your email and click the link to verify your account.</b>
		</form>
	</body>
	</html>