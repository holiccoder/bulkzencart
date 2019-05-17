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
            <li><a href="servers.php">添加服务器</a></li>
            <li class="active"><a href="home.php">网站生产</a></li>
            <li><a href="excelupload.php">产品表格上传</a></li>
            <li><a href="stock.php">产品数据库查看</a></li>
            <li><a href="templates.php">模板管理</a></li>
            <li><a href="account.php">账号管理</a></li>
        </ul>
		<br />
        <div class = "col-md-12 well">
            <button type = "button" class = "btn btn-success"  data-toggle="modal" data-target="#myModal"><span class = "glyphicon glyphicon-plus"></span> 添加网站</button>
            <button type = "button" class = "btn btn-info">当前产品库存总数 :<?php
                $cats = file_get_contents($jsonfile);
                $data = json_decode($cats);
                echo $data->count;
                ?> </button>
            <button class="btn btn-primary btn-danger" id="installssl">SSL批量安装(请在建站后安装)</button>
            <br/>
            <br/>
            <div class = "alert alert-info">
                <table id = "table" class = "table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>服务器代号</th>
                        <th>网站域名</th>
                        <th>店名</th>
                        <th>主题选择</th>
                        <th>目前网站产品数</th>
                        <th>创建时间</th>
                        <th>导入数据</th>
                        <th>图片上传</th>
                        <th>清空网站产品</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = $conn->query("SELECT * FROM `websites`") or die(mysqli_error());

                    while($f_query = $query->fetch_array()){
                        $webid = $f_query['id'];
                        ?>
                        <tr>
                            <td><?php echo $f_query['id']?></td>
                            <td><?php echo $f_query['server_id'];?></td>
                            <td><?php echo $f_query['domain']?></td>
                            <td><?php echo $f_query['name']?></td>
                            <td><?php echo $f_query['theme']?></td>
                            <?php
                            $querypronum = $conn->query("SELECT * FROM `sys_products` WHERE `used` = '$webid'");
                            ?>
                            <td><?php echo $querypronum->num_rows;?></td>
                            <td><?php echo $f_query['datecreated']?></td>
                            <td><button class="btn btn-primary btn-sm importbtn" data-toggle="modal" data-target="#importModal"  webid="<?php echo $f_query['id']?>"> 导入</button></td>
                            <td><button class="btn btn-primary btn-sm imgbtn"><a href="imguploads/<?php echo $f_query['theme']?>.php?id=<?php echo $f_query['id']?>" class="btn-primary" target="_blank">图片上传</a></button></td>
                            <td><button class="btn btn-primary btn-sm btn-danger" id="truncate" websiteid="<?php echo $f_query['id']?>">清空产品</button></td>
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
						<label>网站域名(格式示例www.baidu.com)</label>
						<input type = "text" class = "form-control" id = "domain" value="www.poseidonfishrestaurant.co.uk"/>
					</div>
                    <div class = "form-group">
                        <label>服务器代号选择</label>
                        <select class="form-control" id="serverid">
                            <?php
                            $queryservers = $conn->query("SELECT id FROM `servers`") or die(mysqli_error());
                            while($f_queryservers = $queryservers->fetch_array()) {
                                ?>
                                <option value="<?php echo $f_queryservers["id"];?>"><?php echo $f_queryservers["id"];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class = "form-group">
                        <label>模板选择</label>
                        <select class="form-control" id="theme">
                            <?php
                            $querytemplates = $conn->query("SELECT name FROM `templates`") or die(mysqli_error());
                            while($f_querytemplates = $querytemplates->fetch_array()) {
                                ?>
                                <option value="<?php echo $f_querytemplates["name"];?>"><?php echo $f_querytemplates["name"];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
					<div class = "form-group">
						<label>网站名称</label>
						<input type = "text" class = "form-control" id = "name" value="poseidonfishrestaurant"/>
					</div>
					<div class = "form-group">
						<label>联系邮箱</label>
						<input type = "text" class = "form-control" id = "email" value="contact@poseidonfishrestaurant.co.uk"/>
					</div>
                    <div class = "form-group">
                        <label>联系电话</label>
                        <input type="text" class="form-control" id ="storephone" value="57524234"/>
                    </div>
                    <div class = "form-group">
                        <label>货币选择</label>
                        <select name="currency" id="currency" class="form-control">
                            <option value="USD">美元</option>
                            <option value="ERU">欧元</option>
                            <option value="ASD">澳币</option>
                            <option value="CAD">加元</option>
                            <option value="BPR">英镑</option>
                        </select>
                    </div>
                    <div class = "form-group">
                        <label>选择国家</label>
                        <input type = "text" class = "form-control" id = "country" value="United States"/>
                    </div>
                    <div class = "form-group">
                        <label>地址第二行</label>
                        <input type = "text" class = "form-control" id = "city" value="Los Angeles"/>
                    </div>
                    <div class = "form-group">
                        <label>地址第三行</label>
                        <input type = "text" class = "form-control" id = "address" value="third line"/>
                    </div>
                    <div class = "form-group">
                        <label>首页标题</label>
                        <input type = "text" class = "form-control" id = "metatitle" value="Homepagemetatitle"/>
                    </div>
					<div class = "form-group">
						<label>首页的META关键词</label>
						<input type = "text" class = "form-control" id = "metakeywords" value="homepagemetakeywords"/>
					</div>
					<div class = "form-group">
						<label>首页的META描述</label>
						<input type = "text" class = "form-control" id = "metadescription" value="homepagemetadescriptions"/>
					</div>
					<div id = "loading">
					</div>
			</div><!--modal body ends-->
			<div class="modal-footer">
				<button type="button" id= "signup" class="btn btn-primary"><span class = "glyphicon glyphicon-save"></span> 提交</button>
			</div>
		</div> <!--modal content ends-->
	</div><!--modal dialog ends-->
	</div><!--mymodal ends-->



    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">导入产品数据</h4>
                </div>
                <div class="modal-body">
                        <input type="hidden" id="websiteid">
                        <div id="status-words"></div>
                        <div id="import-progress" style="height:10px; background-color: #2b542c;"></div>
                        <div class = "form-group">
                            <label>产品导入关键词（多个关键词请用英文逗号隔开）</label>
                            <input type = "text" class = "form-control" id ="productkeywords"/>
                        </div>
                        <div class = "form-group">
                            <label>产品数量（一次最好不超过1000）</label>
                            <input type = "text" class = "form-control" id ="productcount"/>
                        </div>
                        <div class = "form-group">
                        <label>网站类型</label>
                            <select name="single" id="websitetype" class="form-control">
                                <option value="0">单一品牌类型</option>
                                <option value="1">多品牌类型</option>
                            </select>
                        </div>
                        <div id = "loading">
                        </div>
                </div><!--modal body ends-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="import"><span class = "glyphicon glyphicon-import"></span> 导入</button>
                </div>
            </div> <!--modal content ends-->
        </div><!--modal dialog ends-->
    </div><!--mymodal ends-->
</body>	
<script src="js/jquery-3.1.1.js"></script>
<script src = "js/bootstrap.js"></script>
<script src = "js/script.js"></script>
<script src = "js/jquery.dataTables.min.js"></script>
<script type = "text/javascript">
    var serverip = "192.168.2.208";
    var serverapi = "http://"+serverip+":8002/api";
    var checkidle = serverapi+"/idle?api=uploadByKeys";
    var importurl = serverapi+'/uploadByKeys';
    var socketurl = "ws://"+serverip+":8003/console";
    var checksslidle = serverapi+"/idle?api=ssl";

	$(document).ready(function(){
		$('#table').DataTable();
		$("#import-progress").hide();
	})

    $(".importbtn").click(function(){
        var webid = $(this).attr("webid");
        $("#websiteid").val(webid);
    });



    $(".imgbtn").click(function(){
        var webid = $(this).attr("webid");
        var theme = $(this).attr("theme");
        $("#websiteid").val(webid);
    });

    $("#installssl").click(function(){

        $.get(checksslidle, function(data){
             var data = JSON.parse(data);
             if(data.idle){
                 var url = serverapi+"/ssl";
                 $.get(url, function(){
                     $(this).attr("disabled", "disabled");
                 });
                 var ws = new WebSocket(socketurl);
                 var reg = {"action":"reg", "handler":"ssl"};
                 ws.onopen = function(){
                     ws.send(JSON.stringify(reg));
                 }

                 ws.onmessage = function(evt){
                      console.log(evt.data);
                 }

             }
        });

    });

    $("button#truncate").click(function(){
        var webid = $(this).attr("websiteid");
        console.log(webid);
        var truncateurl= serverapi+"/release?webId="+webid;
        $.get(truncateurl, function(data){
            var data = JSON.parse(data);
            if(data.msg){
                alert("清空产品数据库成功！");
            }
        })
    })

	$("button#import").click(function(){
        $("#import-progress").show();
        $("#import-progress").css("width", "0%");
	    var productkeywords = $("#productkeywords").val();
	    var productcount = $("#productcount").val();
	    var webid = $("#websiteid").val();
	    var single = $("#websitetype option:selected").val();
        $.get(checkidle, function(data){
              var data = JSON.parse(data);
              if(data.idle){
                   $.ajax({
                       url:importurl,
                       type:"POST",
                       data:{
                           keys:productkeywords,
                           count:productcount,
                           webId:webid,
                           single:single
                       },
                       success:function (data) {
                           if(data){
                               $.get();
                               alert("导入成功");
                           }
                       }
                   });

                   var ws = new WebSocket(socketurl);

                   ws.onopen = function (evt) {
                       var data = {"action":"reg", "handler":"upload"};
                       ws.send(JSON.stringify(data));
                   }

                   ws.onmessage = function(data){
                       var status = JSON.parse(data.data);

                       console.log(status);
                       if(status.key == "progress"){
                           value = status.value.toFixed();
                           $("#import-progress").css("width", value*100+"%");
                           $("#status-words").html(value*100+"%");
                       }

                       if(status.key == "msg"){
                           $("#status-words").html(status.value);
                       }

                   }

              }else{
                  alert("接口正在工作...")
              }
        })
    });



</script>
</html>