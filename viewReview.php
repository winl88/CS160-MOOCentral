<?php
	session_start();
		
	include('connector.php');

	$course_id = $_POST['course_id'];

	$data = mysqli_query($con, "SELECT * FROM reviews WHERE course_id='$course_id'");

	$review = "";
	$check = mysqli_num_rows($data);
	if($check)
	{
		while($row = mysqli_fetch_array($data))
		{
			$review = $review . "\n" . $row['review'];
		}

		echo $review;
	}
	else
		echo 'nothing';
?>