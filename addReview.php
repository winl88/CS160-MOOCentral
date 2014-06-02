<?php
	session_start();
	
	if(isset($_SESSION['sess_user_id'])){	
		include('connector.php');

		$user_id = $_SESSION['sess_user_id'];
		$course_id = $_POST['course_id'];
		$review = $_POST['review'];

		if ($_POST['option'] == 1) {
			mysqli_query($con, "INSERT INTO reviews (user_id, course_id, review) VALUES ('$user_id','$course_id','$review')");
			// "". $_POST['review'] ."")");

			echo 'added';
			return;
		} else if ($_POST['option'] == 2) {
			mysqli_query($con, "UPDATE reviews SET review='$review' WHERE user_id='$user_id' AND course_id='$course_id'");

			echo 'edited';
			return;
		}
	}
	else {
		echo 'guest';
	}
?>