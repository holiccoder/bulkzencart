<?php

	require_once 'conn.php';

	$domain = $_POST['domain'];

	$query = $conn->query("SELECT * FROM `websites` WHERE `domain` = '$domain'") or die(mysqli_error());

	$validate = $query->num_rows;

	if($validate > 0){

		echo "Success";

	}else{

		echo "Error";

	}