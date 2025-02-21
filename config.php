<?php
	$conn = new mysqli("localhost","root","","knm_shoes");
	if($conn->connect_error){
		die("Connection Failed!".$conn->connect_error);
	}
?>