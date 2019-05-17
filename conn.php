<?php
	$conn = new mysqli('localhost', 'root', '', 'bulkzencart');

	if(!$conn){
		die('Could not Connect to Database' . $conn->mysqli_error );
	}