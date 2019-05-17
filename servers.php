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
    <title>网站批量产生系统</title>
</head>
<body class = "alert-warning">
<nav class  = "navbar navbar-inverse">
    <div class = "container-fluid">
        <div class = "navbar-header">
            <a class = "navbar-brand">网站批量产生系统</a>
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
        <li class="active"><a href="servers.php">添加服务器</a></li>
        <li><a href="home.php">网站生产</a></li>
        <li><a href="excelupload.php">产品表格上传</a></li>
        <li><a href="stock.php">产品数据库查看</a></li>
        <li><a href="account.php">账号管理</a></li>
    </ul>
    <br />
    <div class = "col-md-12 well">
        <button type = "button" class = "btn btn-success"  data-toggle="modal" data-target="#myModal"><span class = "glyphicon glyphicon-plus"></span> 增加服务器</button>
        <br/>
        <br/>
        <div class = "alert alert-info">
            <table id = "table" class = "table-bordered">
                <thead>
                <tr>
                    <th>服务器代号</th>
                    <th>服务器IP</th>
                    <th>服务器用户名</th>
                    <th>服务器密码</th>
                    <th>服务器API密钥</th>
                    <th>服务器网站数量</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = $conn->query("SELECT * FROM `servers`") or die(mysqli_error());
                while($f_query = $query->fetch_array()){
                    ?>
                    <tr>
                        <td><?php echo $f_query['id']?></td>
                        <td><?php echo $f_query['serverip']?></td>
                        <td><?php echo $f_query['serveruser']?></td>
                        <td><?php echo $f_query['serverpassword']?></td>
                        <td><?php echo $f_query['serverapikey']?></td>
                        <td><?php echo $f_query['websitesnum']?></td>
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
                <h4 class="modal-title" id="myModalLabel">添加网站</h4>
            </div>
            <div class="modal-body">
                <form method = "POST" enctype = "multipart/form-data">
                    <div class = "form-group">
                        <label>服务器IP</label>
                        <input type = "text" class = "form-control" id = "serverip"/>
                    </div>
                    <div class = "form-group">
                        <label>服务器用户名</label>
                        <input type = "text" class = "form-control" id = "serveruser"/>
                    </div>
                    <div class = "form-group">
                        <label>服务器密码</label>
                        <input type = "text" class = "form-control" id = "serverpassword"/>
                    </div>
                    <div class = "form-group">
                        <label>服务器面板API密钥</label>
                        <input type = "text" class = "form-control" id = "serverapikey"/>
                    </div>
                    <div id = "loading">

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" id= "addserver" class="btn btn-primary"><span class = "glyphicon glyphicon-save"></span> 提交</button>
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