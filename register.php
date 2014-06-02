<?php
include('connector.php');

$username = $_POST['username'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

$user_check = mysqli_query($con, "SELECT username FROM members WHERE username='$username'");
$do_user_check = mysqli_num_rows($user_check);

if($do_user_check)
{
	die("User already exists!");
}

if($password1 != $password2)
{
    header('Location: login.php#footer-wrapper');
}
 
if(strlen($username) > 20)
{
    header('Location: login.php#footer-wrapper');
}
 
$hash = hash('sha256', $password1);
 
function createSalt()
{
    $text = md5(uniqid(rand(), true));
    return substr($text, 0, 3);
}
 
$salt = createSalt();
$password = hash('sha256', $salt . $hash);
 
$username = mysqli_real_escape_string($con, $username);
 
$query = "INSERT INTO members ( username, fname, lname, password, email, salt ) VALUES 
		( '$username', '$fname', '$lname', '$password', '$email', '$salt' )";

mysqli_query($con, $query);

mysqli_close($con);

header('Location: index.php');
?>