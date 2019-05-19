<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

if(isset($_POST["dbname"]) && isset($_POST["domain"]) && isset($_POST["storephone"]) && isset($_POST["storename"])
    && isset($_POST["homemetatitle"]) && isset($_POST["homemetakeywords"]) && $_POST["homemetadescription"] && isset($_POST["theme"])){
    $theme = $_POST["theme"];
    $dbname = $_POST["dbname"];
    $domain = $_POST["domain"];
    $domainwithoutwww = substr($domain, 4);
    $domainpath = '/www/wwwroot/'.$domain.'/';
    $storephone = $_POST["storephone"];
    $storename = $_POST["storename"];
    $homemetatitle = $_POST["homemetatitle"];
    $homemetakeywords = $_POST["homemetakeywords"];
    $homemetadescription = $_POST["homemetadescription"];
    $themedir = '/www/sources/' . $theme . '/*';
    $templatedir = "includes/templates/'.$theme.'/images/";
    $definemain = 'includes/languages/english/html_includes/'.$theme.'/define_main_page.php';
    $metafile = "includes/languages/english/meta_tags.php";
    $dbuser = "root";
    $dbpassword = "XKRT79xh";
    $sqlfile = "zenone.sql";
    $htaccess= '/www/sources/' . $theme . '/.htaccess';
    shell_exec("rm -f .htaccess index.html 404.html");
    function copyFile($originalfile, $targetpath){
        shell_exec("cp -r $originalfile $targetpath");
    }
    copyFile($themedir, $domainpath);
    copyFile($htaccess, $domainpath);
    sleep(1);
    shell_exec("chmod -R 777 cache logs images $templatedir $definemain $metafile");
    //change meta tags
    shell_exec("mysql --user=$dbuser --password=$dbpassword -h localhost -D $dbname < $sqlfile");
    $conn = mysqli_connect("localhost", "root", "XKRT79xh", $dbname);
    $conn->query("UPDATE `configuration` SET `configuration_value` = '$storename' WHERE `configuration_id` = 1");
    $conn->query("UPDATE `configuration` SET `configuration_value` = '$storephone' WHERE `configuration_id` = 3");
    $conn->query("UPDATE `configuration` SET `configuration_value` = '$address' WHERE `configuration_id` = 13");
    function searchReplaceStringinFile($search, $replace, $filePath){
        $str=file_get_contents($filePath);
        $str=str_replace($search, $replace,$str);
        file_put_contents($filePath, $str);
    }

    searchReplaceStringinFile("homepagemetatitle", $homemetatitle, $metafile);
    searchReplaceStringinFile("homepagemetakeywords", $homemetakeywords, $metafile);
    searchReplaceStringinFile("homepagemetadescription", $homemetadescription, $metafile);


//change configure
    $editdbname = 's/zenonedbname/'.$dbname.'/g';
    $editdomain = 's/zenone.com/'.$domain.'/g';
    $editabsolutepath = 's#wwwzenone#'.$domainpath.'#g';
    $configurepath = 'includes/configure.php';
    $adminconfigure = 'boOst-lyo-Plump/includes/configure.php';
    shell_exec("sed -i $editdomain $configurepath && sed -i $editdbname $configurepath && sed -i s/zenonedbuser/root/g $configurepath && sed -i s/zenonedbpassword/XKRT79xh/g $configurepath && sed -i $editabsolutepath $configurepath");
    shell_exec("sed -i $editdomain $adminconfigure && sed -i $editdbname $adminconfigure && sed -i s/zenonedbuser/root/g $adminconfigure && sed -i s/zenonedbpassword/XKRT79xh/g $adminconfigure && sed -i $editabsolutepath $adminconfigure");


    function generateCMS($type,$rename,$domain){
        $randomnum = rand(1,5);
        $targetcmspath = 'includes/languages/english/html_includes/';
        $randomtxt = 'cms/'.$type.'/'.$randomnum.'.txt';
        $targettxt = $targetcmspath.$randomnum.'.txt';
        $targetpathcms = $targetcmspath.$rename;
        shell_exec("cp -r $randomtxt $targetcmspath");
        shell_exec("mv $targettxt $targetpathcms");
        $editdomain = 's/DOMAIN123/'.$domain.'/g';
        shell_exec("sed -i $editdomain $targetpathcms");
    }

    generateCMS("privacy", "define_privacy.php", $domainwithoutwww);
    generateCMS("shipping", "define_shipping.php", $domainwithoutwww);
    generateCMS("terms", "define_conditions.php", $domainwithoutwww);

    echo "success";

}