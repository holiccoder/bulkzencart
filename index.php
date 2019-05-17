<!DOCTYPE HTML>
<?php
	require 'conn.php';
	session_start();
	if(isset($_SESSION["admin_id"])){
	     header("location: home.php");
    }
?>
<html lang = "eng">
	<head>
		<meta charset =  "UTF-8">
		<link rel = "stylesheet" type = "text/css" href = "css/bootstrap.css" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
		<title>网站批量产生系统</title>
	</head>
<body class = "alert-warning">
	<nav class  = "navbar navbar-inverse">
		<div class = "container-fluid">
			<div class = "navbar-header">
				<a class = "navbar-brand">网站批量产生系统</a>
			</div>
		</div>
	</nav>
	<div class = "row">	
		<div class = "col-md-4">
		</div>
		<div class = "col-md-4 alert alert-info">
			<h4>管理员登陆</h4>
			<hr  style = "clear:both;"/>
			<form enctype = "multipart/form-data" method = "POST" >
				<div class = "form-group">
					<label>用户名</label>
					<input type = "text" id = "username" class = "form-control" />
				</div>
				<div class = "form-group">
					<label>密码</label>
					<input type = "password" id = "password" class = "form-control" />
				</div>
				<div id = "loading">
				</div>
				<br />
				<div class  = "form-group">
					<button type = "button" class = "form-control" id = "login"><span class = "glyphicon glyphicon-log-in"></span> 登陆</button>
				</div>
			</form>
		</div>
		<div class = "col-md-4">
		</div>
	</div>	
</body>	
<script src = "js/jquery-3.1.1.js"></script>
<script src = "js/bootstrap.js"></script>
<script src = "js/script.js"></script>
</html>