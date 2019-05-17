<?php

require_once 'conn.php';

$serverip = $_POST["serverip"];

$serveruser = $_POST["serveruser"];

$serverpassword = $_POST["serverpassword"];

$serverapikey = $_POST["serverapikey"];

$creationdate = date("Y-m-d h:m:s");

$conn->query("INSERT INTO `servers` (`serverip`, `serveruser`, `serverpassword`, `serverapikey`, `websitesnum`, `creationdate`) VALUES('$serverip', '$serveruser', '$serverpassword', '$serverapikey', 0, '$creationdate')") or die(mysqli_error());


