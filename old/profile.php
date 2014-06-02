<!DOCTYPE HTML>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Profile</title>

</head>



<?php

	session_start();

	$username = $_SESSION['sess_username'];

	include('connector.php');

	$username = mysqli_real_escape_string($con, $username);

	

	if(mysqli_connect_errno()){

		echo "failed to connect to MySQL: " . mysqli_connect_errno();

	}

	

	$query = "SELECT username, fname, lname, email, password

        FROM members

        WHERE username = '$username';";

		

	$result = mysqli_query($con, $query);

	$userData = mysqli_fetch_array($result, MYSQL_ASSOC);

?>



<body>

<form name="userprofile" action="updateprofile.php" method="post">

  <table width="510" border="0">

		<tr>

			<td colspan="2"><p><strong>User Information</strong></p></td>

		</tr>

		<tr>

			<td>Username:</td>

			<td><?php echo $userData['username'] ?></td>

		</tr>

        <tr>

			<td>First Name:</td>

		  	<td><?php echo $userData['fname'] ?></td>

		</tr>

        <tr>

			<td>Last Name:</td>

		  	<td><?php echo $userData['lname'] ?></td>

		</tr>

        <tr>

			<td>Email:</td>

			<td><?php echo $userData['email'] ?></td>

		</tr>

		<tr>

			<td>&nbsp;</td>

			<td><input type="submit" value="Edit Profile"/></td>

		</tr>

	</table>

</form>

</body>

</html>