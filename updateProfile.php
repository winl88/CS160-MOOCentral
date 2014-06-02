<?php
session_start();
include('connector.php');

$user_id = $_SESSION['sess_user_id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$oldpw = $_POST['oldpw'];
$newpw1 = $_POST['newpw1'];
$newpw2 = $_POST['newpw2'];

$query = "SELECT * FROM members WHERE id='$user_id';";
$result = mysqli_query($con, $query);
$userData = mysqli_fetch_array($result, MYSQL_ASSOC);

$salt = $userData['salt'];
$hash = hash('sha256', $oldpw);
$password = hash('sha256', $salt . $hash);

if($userData['password'] == $password)
{
	if($userData['email'] != $email)
	{
		$user_check = mysqli_query($con, "SELECT email FROM members WHERE email='$email'");
		$do_user_check = mysqli_num_rows($user_check);
		if($do_user_check)
		{
			die("This email already exists!");
		}
		else
			mysqli_query($con, "UPDATE members SET email='$email' WHERE id='$user_id'");
	}

	if($userData['fname'] != $fname)
	{
		mysqli_query($con, "UPDATE members SET fname='$fname' WHERE id='$user_id'");
	}

	if($userData['lname'] != $lname)
	{
		mysqli_query($con, "UPDATE members SET lname='$lname' WHERE id='$user_id'");
	}

	if($newpw1 != $newpw2)
	{
	    header('Location: editProfile.php#footer-wrapper');
	}
	else if($newpw1 != NULL)
	{
		$hash = hash('sha256', $newpw1);
		$password = hash('sha256', $salt . $hash);
		mysqli_query($con, "UPDATE members SET password='$password' WHERE id='$user_id'");
	}
}
else
	die("Incorrect password.");

mysqli_close($con);
header('Location: editProfile.php');
?>