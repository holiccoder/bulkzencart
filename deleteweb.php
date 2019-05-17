<?php

   require_once ("conn.php");

   $webid = $_POST["webid"];

   $remotewebid = "";

   $apiroute = "";

   //先删除远程服务器的，在删除本地的


    $query = $conn->query("DELETE FROM `websites` WHERE 'id' = '$webid'");

    if($query){
        echo "成功删除网站";
    }


