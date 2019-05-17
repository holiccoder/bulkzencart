<!DOCTYPE HTML>
<?php
require_once 'session.php';
require_once 'account_name.php';
?>
<html lang ="eng">
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
        <li><a href="servers.php">添加服务器</a></li>
        <li><a href="home.php">网站生产</a></li>
        <li><a href="excelupload.php">产品表格上传</a></li>
        <li class="active"><a href="stock.php">产品数据库查看</a></li>
        <li><a href="account.php">账号管理</a></li>
        <?php $cats = file_get_contents($jsonfile);
                $data = json_decode($cats);
                $totalcount = $data->count;
                ?>
    </ul>
    <br />
    <div class = "col-md-12 well">
        <table class="table table-striped" id="table">
            <tr>
                <th>1级类别及产品数量</th>
                <th>2级类别及产品数量</th>
                <th>3级类别及产品数量</th>
            </tr>
            <tr>

                <td>
                    <?php
                    $firstcat = $data->children;
                    if(is_array($firstcat)) {
                    foreach ($firstcat as $cat) {
                    ?>
                    <?php echo $cat->category;?>(<?php echo $cat->count;?>)<br/>
                <?php
                  }}
                ?>
                </td>
                <td>
                <?php
                         if(is_array($firstcat)) {
                             foreach ($firstcat as $cat) {
                                   if(is_array($cat->children)){
                                        $secondcat = $cat->children;
                                        foreach($secondcat as $second){
                                            $secondcateogryname =  $second->category;
                                            $secondcateogrycount = $second->count;
                                            echo $secondcateogryname.'('.$secondcateogrycount.')'.'<br/>';

                                        }
                                   }
                             }
                         }
                             ?>
                </td>
                <td>
                    <?php
                    if(is_array($firstcat)) {
                        foreach ($firstcat as $cat) {
                            if(is_array($cat->children)){
                                $secondcat = $cat->children;
                                foreach($secondcat as $second){
                                    if(is_array($second->children)){
                                        $thirdcat = $second->children;
                                        foreach($thirdcat as $third){
                                            echo $third->category.'('.$third->count.')';
                                            echo "<br>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </td>
                <td>

                </td>

            </tr>
            <tr>

            </tr>

        </table>
    </div>

<script src="js/jquery-3.1.1.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/script.js"></script>
    <script>
        var url = "http://test.test/inventory.json";
        getDepth = function (obj) {
            var depth = 0;
            if (obj.children) {
                obj.children.forEach(function (d) {
                    var tmpDepth = getDepth(d);
                    if (tmpDepth > depth) {
                        depth = tmpDepth;
                    }
                })
            }
            return 1 + depth;
        };

        $.get(url, function(data){
            var depth = getDepth(data);
            for(var i=0; i<depth; i++){
                 $("#levels").html(`<th>`+i+`级类别及数量</th>`);
            }
        });
    </script>
</body>
</html>