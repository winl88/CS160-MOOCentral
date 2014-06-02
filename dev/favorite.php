<?php
	session_start();
	
	if(isset($_SESSION['sess_user_id'])){	
		include('connector.php');
		
		if ($_POST['option'] == 1) {
		
			$result = mysqli_query($con, "INSERT INTO member_faves (member_id, course_id)				VALUES (" . $_SESSION['sess_user_id'] . "," . $_POST['course_id'] . ")");
			echo 'added';
			return;
		}
		
		else if ($_POST['option'] == 2) {
			$result = mysqli_query($con, "DELETE FROM member_faves (member_id, course_id)
				WHERE member_id='" . $_SESSION['sess_user_id'] . "' AND course_id='" . $_POST['course_id'] . "'");

			echo 'removed';
			return;
		
		} else {
			echo 'fail';
			return;
		}           
	
	} else {
		echo 'guest';
	}
?>