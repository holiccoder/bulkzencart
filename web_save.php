<?php

require_once 'conn.php';
require_once 'btapi.php';

$domain = $_POST['domain'];
$domainwithoutwww = substr($domain, 4);
$serverid = $_POST["serverid"];
$storename = $_POST['storename'];
$email = $_POST["email"];
$address = $_POST['address'];
$currency = $_POST["currency"];
$theme = $_POST['theme'];
$metatitle = $_POST['homemetatitle'];
$storephone = $_POST["storephone"];
$metakeywords = $_POST['homemetakeywords'];
$metadescription = $_POST['homemetadescription'];
$serverrow = $conn->query("SELECT * FROM `servers` WHERE `id` = '$serverid'");
$templaterow = $conn->query("SELECT * FROM `templates` WHERE `name` = '$theme'");
$serverarray = $serverrow->fetch_array();
$templatearray = $templaterow->fetch_array();
$templatedir = $templatearray["templatedir"];
$serverip = $serverarray["serverip"];
$serveruser = $serverarray["serveruser"];
$serverpassword = $serverarray["serverpassword"];
$serverapikey = $serverarray["serverapikey"];
$websitesnum = $serverarray["websitesnum"];
$domainpath = '/www/wwwroot/'.$domain.'/';
$api = new bulkWebsiteBuild($serverip, $serverapikey, $serveruser, $serverpassword);
$dbdetail = $api->addWebsite($domain);
$dbuser = "root";
$dbpassword = "XKRT79xh";
$creationdate = date("Y-m-d h:m:s");

if($dbdetail){
    $dbname = $dbdetail["databaseUser"];
    $api->sshExecCmd("cp -r /www/sources/shell.php $domainpath");
    $domainposturl = $domain.'/shell.php';
    $dataArray = array(
        "domain" => $domain,
        "storename" => $storename,
        "storephone" => $storephone,
        "address" => $address,
        "homemetatitle" => $metatitle,
        "homemetakeywords" => $metakeywords,
        "homemetadescription" => $metadescription,
        "dbname" => $dbname,
        "theme" => $theme
    );

     $result = curlPost($domainposturl, $dataArray);
     if($result){
         $conn->query("INSERT INTO `websites` (`server_id`, `domain`, `name`, `address`, `email`, `theme`, `metatitle`, `metakeywords`, `metadescription`, `absolutepath`, `dbname`, `dbuser`, `dbpassword`,`currency`,`datecreated` ) VALUES('$serverid', '$domain','$storename', '$address', '$email', '$theme','$metatitle', '$metakeywords', '$metadescription', '$domainpath', '$dbname', '$dbuser', '$dbpassword','$currency','$creationdate')") or die(mysqli_error());
     }

     echo "success";

}

function curlPost($url, $dataArray){
     $curl = curl_init();
     curl_setopt($curl, CURLOPT_URL, $url);
     curl_setopt($curl, CURLOPT_HEADER, 1);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($curl, CURLOPT_POST, 1);
     $post_data = $dataArray;
     curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
     $data = curl_exec($curl);
     curl_close($curl);
     return $data;
}



