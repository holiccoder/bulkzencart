<?php
require_once 'conn.php';

$serverip = $_POST['serverip'];

$query = $conn->query("SELECT * FROM `servers` WHERE `serverip` = '$serverip'") or die(mysqli_error());

$validate = $query->num_rows;

if($validate > 0){

echo "Success";

}else{

echo "Error";

}