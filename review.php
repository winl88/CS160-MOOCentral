<?php
	session_start();
	
	if(isset($_SESSION['sess_user_id'])){	
		include('connector.php');

		$user_id = $_SESSION['sess_user_id'];
		$course_id = $_POST['course_id'];
		$time = date("Y-m-d H:i:s");

		$review = htmlentities($_POST['review']);
		if(strlen($review) < 1)
		{
			echo 'empty';
			return;
		}
		
		$review = "(" . $time . "): " . $review;

		if ($_POST['option'] == 1)
		{
			mysqli_query($con, "INSERT INTO reviews (user_id, course_id, review) VALUES ('$user_id', '$course_id', \"$review\")");

			echo 'added';
			return;
		}
		else if ($_POST['option'] == 2)
		{
			$query = mysqli_query($con, "SELECT * FROM reviews WHERE user_id='$user_id' AND course_id='$course_id'");
			$data = mysqli_fetch_array($query);

			$newReview = $data['review'] . "\nUpdate " . $review;

			mysqli_query($con, "UPDATE reviews SET review='$newReview' WHERE user_id='$user_id' AND course_id='$course_id'");

			echo 'updated';
			return;
		}
	}
	else {
		echo 'guest';
	}
?>