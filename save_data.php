<?php

	require_once 'conn.php';
	require_once 'btapi.php';

	$domain = $_POST['domain'];
	$domainwithoutwww = substr($domain, 4);
	$serverid = $_POST["serverid"];
	$name = $_POST['name'];

	$email = $_POST["email"];

	$address = $_POST['address'];

	$currency = $_POST["currency"];

	$theme = $_POST['theme'];

	$metatitle = $_POST['metatitle'];

	$storephone = $_POST["storephone"];

	$metakeywords = $_POST['metakeywords'];

	$metadescription = $_POST['metadescription'];

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

	$api = new bulkWebsiteBuild($serverip, $serverapikey, $serveruser, $serverpassword);
	$domainpath = '/www/wwwroot/'.$domain.'/';
	$htaccess = $domainpath.'.htaccess';
    $indexfile = $domainpath.'index.html';
    $fileunderdomainpath = '/www/sources/'.$theme.'/.htaccess';
	$originalfiles = '/www/sources/'.$theme.'/*';

	$websuccess = $api->addWebsite($domain);

    $creationdate = date("Y-m-d h:m:s");

    if($websuccess){

        $dbname = $websuccess["databaseUser"];
        echo $dbname;
        $dbuser = 'root';
        $dbpassword = 'XKRT79xh';

        $editdomain = 's/zenone.com/'.$domain.'/g';
        $putpath = $domainpath . 'includes/configure.php';
        $adminputpath = $domainpath.'boOst-lyo-Plump/includes/configure.php';
        $editsql = $domainpath.'zenone.sql';
        $metafilepath = $domainpath.'includes/languages/english/meta_tags.php';

        $editdbname = 's/zenonedbname/'.$dbname.'/g';
        $editdbpassword = 's/zenonedbpassword/'.$dbpassword.'/g';
        $editdbuser = 's/zenonedbuser/'.$dbuser.'/g';

        $editabsolutepath = 's#wwwzenone#'.$domainpath.'#g';

        $editadminabsolutepath = 's#wwwzenone#'.$domainpath.'#g';
        $editstorename = 's/demostorename/'.$domainwithoutwww.'/g';
        $editstorephone = 's/57524238914/'.$storephone.'/g';

        $editmetatitle = 's/homepagetitle/'.$metatitle.'/g';
        $editmetakeywords = 's/homepagemetakeywords/'.$metakeywords.'/g';
        $editmetadescription = 's/homepagemetadescription/'.$metatitle.'/g';

        $editcms = 's/DOMAIN123/'.$domainwithoutwww.'/g';

        $randomnum = rand(1,5);
        $randomtermspath = $domainpath.'cms/terms/'.$randomnum.'.txt';
        $randomprivacypath = $domainpath.'cms/privacy/'.$randomnum.'.txt';
        $randomaboutpath = $domainpath.'cms/about/'.$randomnum.'.txt';
        $randomshippingpath = $domainpath.'cms/shipping/'.$randomnum.'.txt';
        $randomreturnpath = $domainpath.'cms/return/'.$randomnum.'.txt';
        $targetcmspath = $domainpath.'includes/languages/english/html_includes/';

        $originalprivacy = $targetcmspath.$randomnum.'.txt';
        $targetprivacy = $targetcmspath.'define_privacy.php';
        $originalterms = $targetcmspath.$randomnum.'.txt';
        $targetterms = $targetcmspath.'define_conditions.php';
        $originalshipping = $targetcmspath.$randomnum.'.txt';
        $targetshipping = $targetcmspath.'define_shipping.txt';
        $originalabout = $targetcmspath.$randomnum.'.txt';
        $targetabout = $targetcmspath.'define_page_2.php';
        $targetreturn = $targetcmspath.'define_page_3.php';
        $sqlfile = $domainpath.'zenone.sql';
        $cachepath = $domainpath.'cache';
        $imagedir = $domainpath.'images';
        $templatedirectory = $domainpath.$templatedir;
        //复制一定.htaccess文件
        $api->sshExecCmd("cp -r $originalfiles $domainpath && rm -f $htaccess $indexfile && cp -r $fileunderdomainpath $domainpath && cp -r $randomtermspath $targetcmspath && mv $originalterms $targetterms && sed -i $editcms $targetterms && cp -r $randomprivacypath $targetcmspath && mv $originalprivacy $targetprivacy && sed -i $editcms $targetprivacy && cp -r $randomshippingpath $targetcmspath && mv $originalshipping $targetshipping && sed -i $editcms $targetshipping");
        sleep(1);
        $api->sshExecCmd("sudo chmod -R 777 $templatedirectory $cachepath $imagedir");
        $api->sshExecCmd("sed -i '".$editdomain."' '".$putpath."' && sed -i '".$editdbname."' '".$putpath."' && sed -i '".$editdbuser."' '".$putpath."' && sed -i '".$editdbuser."' '".$putpath."' && sed -i '".$editdbpassword."' '".$putpath."' && sed -i '".$editabsolutepath."' '".$putpath."'");
        $api->sshExecCmd("sed -i '".$editdbpassword."' '".$adminputpath."' && sed -i '".$editdbname."' '".$adminputpath."' && sed -i '".$editdbuser."' '".$adminputpath."' && sed -i '".$editdomain."' '".$adminputpath."' && sed -i '".$editadminabsolutepath."' '".$adminputpath."'");
        $api->sshExecCmd("sed -i '".$editmetatitle."' '".$metafilepath."' && sed -i '".$editmetakeywords."' '".$metafilepath."' && sed -i '".$editmetadescription."' '".$metafilepath."'");
        sleep(1);
        $api->sshExecCmd("mysql --user=$dbuser --password=$dbpassword -h localhost -D $dbname < $sqlfile");
    }
     $conn->query("INSERT INTO `websites` (`server_id`, `domain`, `name`, `address`, `email`, `theme`, `metatitle`, `metakeywords`, `metadescription`, `absolutepath`, `dbname`, `dbuser`, `dbpassword`,`currency`,`datecreated` ) VALUES('$serverid', '$domain','$name', '$address', '$email', '$theme','$metatitle', '$metakeywords', '$metadescription', '$domainpath', '$dbname', '$dbuser', '$dbpassword','$currency','$creationdate')") or die(mysqli_error());


