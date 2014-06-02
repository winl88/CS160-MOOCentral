<?PHP

$uname = "";
$pword = "";
$errorMessage = "";
$num_rows = 0;

function quote_smart($value, $handle) {

   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }

   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value, $handle) . "'";
   }
   return $value;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['username'];
	$pword = $_POST['password'];

	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);

/*
	$user_name = "root";
	$pass_word = "";
	$database = "moocs160";
	$server = "localhost";

*/
	$user_name = "sjsucsor_s2g414s";
	$pass_word = "abcd#1234";
	$database = "sjsucsor_160s2g42014s";
	$server = "localhost";


	$db_handle = mysql_connect($server, $user_name, $pass_word);
	$db_found = mysql_select_db($database, $db_handle);

	if ($db_found) {

		$uname = quote_smart($uname, $db_handle);
		$pword = quote_smart($pword, $db_handle);
		//$pword = md5($pword);

		$SQL = "SELECT * FROM login WHERE L1 = $uname AND L2 = $pword";
		$result = mysql_query($SQL);
		
		if($result === false){
			die(mysql_error());
		}
		$num_rows = mysql_num_rows($result);

		
		if ($result) {
			if ($num_rows > 0) {
				session_start();
				$_SESSION['login'] = "1";
				header ("Location: profile.php?ref=$uname");
			}
			else {
				//$errorMessage = "Invalid Login";
				//session_start();
				//$_SESSION['login'] = '';

				session_start();
				$_SESSION['login'] = "";
				header ("Location: signup.php");
				
			}	
		}
		else {
			$errorMessage = "Error logging on";
		}

	mysql_close($db_handle);

	}

	else {
		$errorMessage = "Error logging on";
	}

}


?>


<html>
<head>
<title>Profile</title>
<style>
			#titletags {
					font-family:"Times New Roman", Times, serif;
					font-size: 24px;
					color: blue;

				}
		</style>
</head>
<body>
	<?php
			$con = mysqli_connect("localhost", "sjsucsor_s2g414s", "abcd#1234", "sjsucsor_160s2g42014s");
			//$con = mysqli_connect("localhost", "root", "", "moocs160");	
			if(mysqli_connect_errno()){
				echo "failed to connect to MySQL: " . mysqli_connect_errno();
			}

			$id = htmlspecialchars($_GET["ref"]);
			echo "<h1> USER PROFILE ";

			if($result = mysqli_query($con, "Select * from profile where user = $id")){
			
			while($row = mysqli_fetch_array($result)){
			
				
				//echo  "<div id=\"titletags\">" . "User Name: " . "</div>" . $row['user'];
				echo  "<div id=\"titletags\">" . "Name: " . "</div>" . $row['first'] ." ". $row['last'];
				echo  "<div id=\"titletags\">" . "Birthday: " . "</div>" . $row['month'] . " " . $row['day'] . " " .$row['year'];
				echo  "<div id=\"titletags\">" . "Favorite Color: " . "</div>" . $row['color'];
				echo  "<div id=\"titletags\">" . "Interest: " . "</div>" . $row['interests'];
				echo  "<div id=\"titletags\">" . "Languages: " . "</div>" . $row['languages'];
				echo  "<div id=\"titletags\">" . "Comments: " . "</div>" . $row['comments'];

			}
			echo "<br /><a href=\"index.php\">Return to front page</a>";
		}else{
			echo (mysql_error());
		}
		?>


</body>
</html>