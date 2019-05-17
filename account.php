<!DOCTYPE HTML>
<?php
	require_once 'session.php';
	require_once 'account_name.php';
?>
<html lang = "eng">
	<head>
		<meta charset =  "UTF-8">
		<link rel = "stylesheet" type = "text/css" href = "css/bootstrap.css" />
		<link rel = "stylesheet" type = "text/css" href = "css/jquery.dataTables.css" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
		<title>网站批量生产系统</title>
	</head>
<body class = "alert-warning">
	<nav class  = "navbar navbar-inverse">
		<div class = "container-fluid">
			<div class = "navbar-header">
				<a class = "navbar-brand">网站生产</a>
			</div>
				<ul class="nav navbar-nav navbar-right">
					<li><a><span class = "glyphicon glyphicon-user"></span> <?php echo $acc_name?></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">设置 <span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="logout.php">退出</a></li>
						</ul>
					</li>
				</ul>
		</div>
	</nav>
	<div class = "container-fluid">
        <ul class="nav nav-pills">
            <li><a href="servers.php">添加服务器</a></li>
            <li><a href="home.php">网站生产</a></li>
            <li><a href="excelupload.php">产品表格上传</a></li>
            <li><a href="stock.php">产品数据库查看</a></li>
            <li class="active"><a href="account.php">账号管理</a></li>
        </ul>
		<br />
		<div class = "col-md-12 well">
			<button type = "button" class = "btn btn-success"  data-toggle="modal" data-target="#myModal"><span class = "glyphicon glyphicon-plus"></span> 增加新成员</button>
			<br/>
			<br/>
			<div class = "alert alert-info">
				<table id = "table" class = "table-bordered">
					<thead>
						<tr>
							<th>用户名</th>
							<th>密码</th>
							<th>动作</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$query = $conn->query("SELECT * FROM `admin`") or die(mysqli_error());
							while($f_query = $query->fetch_array()){
						?>
						<tr>
							<td><?php echo $f_query['username']?></td>
							<td><?php echo md5($f_query['password'])?></td>
							<td><center><a href = "account_edit.php?admin_id=<?php echo $f_query['admin_id']?>" class = "btn btn-warning"><span class = "glyphicon glyphicon-edit"></span>  更新</a> | <a  href = "delete_admin.php?admin_id=<?php echo $f_query['admin_id']?>" class = "btn btn-danger"><span class = "glyphicon glyphicon-trash"></span> 删除</a></center></td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">账号管理</h4>
			</div>
			<div class="modal-body">
				<form method = "POST" enctype = "multipart/form-data">
					<div class = "form-group">
						<label>用户名</label>
						<input type = "text" class = "form-control" id = "username"/>
					</div>
					<div class = "form-group">
						<label>密码</label>
						<input type = "password" class = "form-control" id = "password"/>
					</div>
					<div id = "loading">
						
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" id= "signup" class="btn btn-primary"><span class = "glyphicon glyphicon-save"></span> Save</button>
			</div>
				</form>
		</div>
	</div>
	</div>
</body>	
<script src = "js/jquery-3.1.1.js"></script>
<script src = "js/bootstrap.js"></script>
<script src = "js/script.js"></script>
<script src = "js/jquery.dataTables.min.js"></script>
<script type = "text/javascript">
	$(document).ready(function(){
		$('#table').DataTable();
	})
</script>
</html>