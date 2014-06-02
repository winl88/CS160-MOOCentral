<?php



	$con = mysqli_connect("localhost", "sjsucsor_s2g414s", "abcd#1234", "sjsucsor_160s2g42014s");

	//$con = mysqli_connect("localhost", "root", "root", "moocs160");	



	if(mysqli_connect_errno()){

		echo "failed to connect to MySQL: " . mysqli_connect_errno();

	}

?>