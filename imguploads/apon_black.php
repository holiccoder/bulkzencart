<?php
require_once ("../conn.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet" type = "text/css" href = "../css/bootstrap.css" />
    <title>APON_LITE主题图片上传</title>
    <style>

        input[type='file']{
            padding-top: 0px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<style>
    body{
        background-color: #fcf8e3;
    }
</style>
<?php
$id = $_GET['id'];
$query = $conn->query("SELECT * FROM `websites` WHERE `id` = '$id'") or die(mysqli_error());
$fquery = $query->fetch_array();
$domain = $fquery["domain"];
?>
<div class="container">


    <div class="col-md-6 col-md-offset-3">
        <h2 class="text-center">APON_LITE主题图片上传</h2>
        链接示例：<br>
        推荐产品：index.php?main_page=featured_products <br>
        促销产品：index.php?main_page=specials <br>
        最新产品：index.php?main_page=new_products <br>
            <div class="well">
                <form enctype="multipart/form-data" id="uploadlogo">
                <div class="form-group">
                    <label for="logo">LOGO上传</label>(258x84，gif);
                    <input type="file" class="form-control" name="logo" id="logo">
                </div>
                </form>
                <form enctype="multipart/form-data" id="uploadslideimg1">
                <div class="form-group">
                    <label for="slideimg1">幻灯片图片1上传</label>(1170x430，jpg);
                    <input type="file" class="form-control" name="slideimg1" id="slideimg1">
                </div>
                </form>
                <div class="form-group">
                    <label for="slideimg1">幻灯片图片1链接上传</label>
                    <input type="text" class="form-control" name="slideimg1link" id="slideimg1link">
                </div>
                <form enctype="multipart/form-data" id="uploadslideimg2">
                <div class="form-group">
                    <label for="slideimg2">幻灯片图片2上传</label>(1170x430，jpg);
                    <input type="file" class="form-control" name="slideimg2" id="slideimg2">
                </div>
                </form>
                <div class="form-group">
                    <label for="slideimg1">幻灯片图片2链接上传</label>
                    <input type="text" class="form-control" name="slideimg2link" id="slideimg1link">
                </div>
                <form enctype="multipart/form-data" id="uploadslidedownimg1">
                <div class="form-group">
                    <label for="slidedownimg1">幻灯片下端图片1上传</label>(384x230,jpg)
                    <input type="file" class="form-control" name="slidedownimg1" id="slidedownimg1">
                </div>
                </form>
                <div class="form-group">
                    <label for="slidedownimg1">幻灯片下端图片1链接上传</label>
                    <input type="text" class="form-control" name="slidedownimg1link" id="slidedownimg1link">
                </div>
                <form enctype="multipart/form-data" id="uploadslidedownimg2">
                <div class="form-group">
                    <label for="slidedownimg2">幻灯片下端图片2上传</label>(384x230,jpg)
                    <input type="file" class="form-control" name="slidedownimg2" id="slidedownimg2">
                </div>
                </form>
                <div class="form-group">
                    <label for="slidedownimg1">幻灯片下端图片2链接上传</label>
                    <input type="text" class="form-control" name="slidedownimg2link" id="slidedownimg2link">
                </div>
                <form enctype="multipart/form-data" id="uploadslidedownimg3">
                <div class="form-group">
                    <label for="slidedownimg2">幻灯片下端图片3上传</label>(384x230,jpg)
                    <input type="file" class="form-control" name="slidedownimg3" id="slidedownimg3">
                </div>
                </form>
                <div class="form-group">
                    <label for="slidedownimg1">幻灯片下端图片3链接上传</label>
                    <input type="text" class="form-control" name="slidedownimg3link" id="slidedownimg3link">
                </div>
            </div>

    </div>
</div>


<script src="../js/jquery-3.1.1.js"></script>
<script>
    function upload(name){
        $("input#"+name).change(function(){
            $.ajax({
                url: "http://<?php echo $domain;?>/imagereplace.php",
                type: 'POST',
                cache: false,
                data: new FormData($('#upload'+name)[0]),
                processData: false,
                contentType: false
            }).done(function(res) {
                alert(res);
            }).fail(function(res) {
                console.log(res);
            });
        });
    }

    upload("logo");
    upload("slideimg1");
    upload("slideimg2");
    upload("slidedownimg1");
    upload("slidedownimg2");
    upload("slidedownimg3");

    $("input#slideimg1link").change(function(){
            var updatelinkurl = "http://<?php echo $domain;?>/imagereplace.php";
             $.ajax({
                 url:updatelinkurl,
                 type:"POST",
                 data:{
                     slideimg1link:$("#slideimg1link").val()
                 },
                 success:function(data){
                     if(data){
                         alert("link updated");
                     }else{
                         console.log("failure");
                     }
                 }
             })
    });

    $("input#slideimg2link").change(function(){
        var updatelinkurl = "http://<?php echo $domain;?>/imagereplace.php";
        $.ajax({
            url:updatelinkurl,
            type:"POST",
            data:{
                slideimg2link:$("#slideimg2link").val()
            },
            success:function(data){
                if(data){
                    alert("link updated");
                }else{
                    console.log("failure");
                }
            }
        })
    });

    $("input#slidedownimg1link").change(function(){
        var updatelinkurl = "http://<?php echo $domain;?>/imagereplace.php";
        $.ajax({
            url:updatelinkurl,
            type:"POST",
            data:{
                slidedownimg1link:$("#slidedownimg1link").val()
            },
            success:function(data){
                if(data){
                    alert("link updated");
                }else{
                    console.log("failure");
                }
            }
        })
    });

    $("input#slidedownimg2link").change(function(){
        var updatelinkurl = "http://<?php echo $domain;?>/imagereplace.php";
        $.ajax({
            url:updatelinkurl,
            type:"POST",
            data:{
                slidedownimg2link:$("#slidedownimg2link").val()
            },
            success:function(data){
                if(data){
                    alert("link updated");
                }else{
                    console.log("failure");
                }
            }
        })
    });

    $("input#slidedownimg3link").change(function(){
        var updatelinkurl = "http://<?php echo $domain;?>/imagereplace.php";
        $.ajax({
            url:updatelinkurl,
            type:"POST",
            data:{
                slidedownimg3link:$("#slidedownimg3link").val()
            },
            success:function(data){
                if(data){
                    alert("link updated");
                }else{
                    console.log("failure");
                }
            }
        })
    });
</script>
</body>
</html>
