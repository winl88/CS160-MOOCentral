<?php
	session_start();
	
	if(isset($_SESSION['sess_user_id'])){
		
		include('connector.php');

		$res = mysqli_query($con, "select thumbs_up from rating_vote where user_id = '" . $_SESSION['sess_user_id'] . "' and course_id = '" . $_POST['course_id'] . "'");
		
		$num_res = mysqli_num_rows($res); 
		
		$thumbs_up = true;
		
		if ($_POST['ponone'] == -1) {
		
			$thumbs_up = false;
			
		}
		
		if ($num_res == 0) {
		
			////// User has never voted before.
			
			////// Cancel auto commit option in the database
			mysqli_autocommit($con, FALSE);
			
			////// Insert some values 
			mysqli_query($con, "insert into rating_vote (course_id, user_id, thumbs_up) values ('" . 
					$_POST['course_id'] . "', '" .$_SESSION['sess_user_id'] . "', '" . $thumbs_up . "')" );

			mysqli_query($con, "update rating set rate = rate + " . $_POST['ponone'] . " where course_id = " . $_POST['course_id']);

			////// Commit transaction
			mysqli_commit($con);

			////// Close connection
			mysqli_close($con);

			echo 'success';
			
			return;
		
		} else {
			////// User has voted before.
			
			$row = mysqli_fetch_assoc($res);
			
			if ($row['thumbs_up'] && $thumbs_up) {
				echo 'twoup';
				return;
			}
			
			if (!$row['thumbs_up'] && !$thumbs_up) {
				echo 'twodown';
				return;
			}
			
			////// Cancel auto commit option in the database
			mysqli_autocommit($con, FALSE);
			
			mysqli_query($con, "delete from rating_vote where user_id = " . $_SESSION['sess_user_id'] . " and course_id = " . $_POST['course_id']);
			
			mysqli_query($con, "update rating set rate = rate + " . $_POST['ponone'] . " where course_id = " . $_POST['course_id']);

			////// Commit transaction
			mysqli_commit($con);

			////// Close connection
			mysqli_close($con);

			echo 'success';
			
			return;
		}           
	
	} else {
		echo 'guest';
	}
?>
