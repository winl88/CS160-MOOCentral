<?php
	session_start();

	$username = $_POST['username'];
	$password = $_POST['password'];

	include('connector.php');

	$username = mysqli_real_escape_string($con, $username);

	$query = "SELECT id, username, password, salt
			FROM members
			WHERE username = '$username';";

	$result = mysqli_query($con, $query);

	if(mysqli_num_rows($result) == 0) // User not found. So, redirect to login_form again.
	{
		header('Location: index.php#footer-wrapper');
	}

	$userData = mysqli_fetch_array($result, MYSQL_ASSOC);
	$hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );

	if($hash != $userData['password']) // Incorrect password. So, redirect to login_form again.
	{
		echo "Wrong Password!";
	} else { // Redirect to home page after successful login.
		session_regenerate_id();
		$_SESSION['sess_user_id'] = $userData['id'];
		$_SESSION['sess_username'] = $userData['username'];
		session_write_close();
		header('Location: index.php');
	}
?>