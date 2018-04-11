<?php
	
	ob_start();
	session_start();

	
	$timezone=date_default_timezone_set("Europe/Belgrade");
	$con=mysqli_connect("localhost","root","","1slotify");

	if(mysqli_connect_errno()){
		echo "failed to connect: ".mysqli_connect_errno();
	}





?>