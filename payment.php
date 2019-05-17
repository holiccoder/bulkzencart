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
    <style>
        #id-excel-progress {
            display: none;
        }
    </style>
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
        <li><a href="servers.php">添加服务器</a></li>
        <li><a href="home.php">网站生产</a></li>
        <li><a href="excelupload.php">产品表格上传</a></li>
        <li><a href="stock.php">产品数据库查看</a></li>
        <li><a href="account.php">账号管理</a></li>
        <li class="active"><a href="payment.php">支付管理</a></li>
        <li><a href="#">当前库存产品总数:<?php
                $cats = file_get_contents($jsonfile);
                $data = json_decode($cats);
                $totalcount = $data->count;
                ?> <?php echo $totalcount;?></a></li>
    </ul>
    <br />
    <div class = "col-md-12 well">
        this is payment page
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">上传文件</h4>
            </div>

            <div class="modal-body">
                <div id="id-excel-progress"><img src="images/loading.gif">上传中...请稍等</div>
                <div class = "form-group">
                    <label>选择文件</label>
                    <input type="file" id="id-excel" class="form-control"/>
                </div>
                <div class = "form-group">
                    <label>备注</label>
                    <input type="text" name="note" class="form-control" value="备注"/>
                </div>
                <div id="loading"></div>
            </div>
            <div class="modal-footer">
                <input type="submit" id="submit" class="btn btn-primary" value="提交" />
            </div>
        </div>
    </div>
</div>
</body>
<script src = "js/jquery-3.1.1.js"></script>
<script src = "js/bootstrap.js"></script>
<script src = "js/uploader.js"></script>
<script src = "js/script.js"></script>
<script src = "js/jquery.dataTables.min.js"></script>
<script type = "text/javascript">
    $(document).ready(function(){
        $('#table').DataTable();
    });

</script>
</html>