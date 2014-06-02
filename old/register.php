<?php

$username = $_POST['username'];

$fname = $_POST['fname'];

$lname = $_POST['lname'];

$email = $_POST['email'];

$password1 = $_POST['password1'];

$password2 = $_POST['password2'];



echo $password1 != $password2;

if($password1 != $password2)

	header('Location: registration.html');



else if(strlen($username) > 20)

	header('Location: registration.html');



else {

	$hash = hash('sha256', $password1);

	 

	function createSalt()

	{

		$text = md5(uniqid(rand(), true));

		return substr($text, 0, 3);

	}



	$salt = createSalt();

	$password = hash('sha256', $salt . $hash);



	include('connector.php');



	$username = mysqli_real_escape_string($con, $username);



	$query = "INSERT INTO members (username, fname, lname, email, password, salt) VALUES 

			('$username', '$fname', '$lname', '$email', '$password', '$salt')";



	mysqli_query($con, $query);



	mysqli_close($con);



	header('Location: index.php');

}

?>