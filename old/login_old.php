<?php
//ob_start();
//session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$conn = mysqli_connect("localhost", "sjsucsor_s2g414s", "abcd#1234", "sjsucsor_160s2g42014s");

$username = mysqli_real_escape_string($conn, $username);

//SELECT id, user, password, salt
$query = "SELECT password, salt
        FROM profile
        WHERE user = '$username';";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 0) // User not found. So, redirect to login_form again.

{

    header('Location: signup.php');

}

$userData = mysqli_fetch_array($result, MYSQL_ASSOC);

$hash = hash('sha256', $userData['salt'] . hash('sha256', $password) ); 

if($hash != $userData['password']) // Incorrect password. So, redirect to login_form again.

{

    header('Location: signup.php');

}else{ // Redirect to home page after successful login.
    //session_regenerate_id();
	//$_SESSION['sess_user_id'] = $userData['id'];
	//$_SESSION['sess_username'] = $userData['user'];
	//session_write_close();
    header('Location: index.php');

}

?>