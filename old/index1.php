<!DOCTYPE HTML>
<html>
	
	<head>
		<title>MOOCentral</title>		
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
 		<script src="//datatables.net/download/build/nightly/jquery.dataTables.js"></script>
 		<link href="//datatables.net/download/build/nightly/jquery.dataTables.css" rel="stylesheet" type="text/css" />
 		<link rel="stylesheet" type="text/css" href="styles.css">
 		<script>
 			 $(document).ready( function () {
 	 			var table = $('#mooTest').DataTable();
 	 			} );

 			 $(document).ready(function(){
				  $('#login-trigger').click(function(){
				    $(this).next('#login-content').slideToggle();
				    $(this).toggleClass('active');          
				    
				    if ($(this).hasClass('active')) $(this).find('span').html('&#x25B2;')
				      else $(this).find('span').html('&#x25BC;')
				    })
			});
 		</script>
	</head>



	
<!--
	<div align="center">
	 <a href="data.php">Testing Purposes page</a> 
	</div>
-->

<?php
	session_start();
	$con = mysqli_connect("localhost", "sjsucsor_s2g414s", "abcd#1234", "sjsucsor_160s2g42014s");
	//$con = mysqli_connect("localhost", "root", "", "moocs160");	
	if(mysqli_connect_errno()){
		echo "failed to connect to MySQL: " . mysqli_connect_errno();
	}

	$data = mysqli_query($con, "Select * from course_data join coursedetails where coursedetails.course_id = course_data.id");

 	if(isset($_POST['username'], $_POST['password']))
	{
		// connectct to server and select databse.
		mysql_connect("localhost", "sjsucsor_s2g414s", "abcd#1234")or die("cannot connect"); 
		mysql_select_db("sjsucsor_160s2g42014s")or die("cannot select DB");

		$input_username = $_POST['username'];

		$input_username = stripslashes($input_username);
		$input_username = mysql_real_escape_string($input_username);

		$sql="SELECT * FROM profile WHERE user='$input_username'";
		$result=mysql_query($sql);

		$row = mysql_fetch_row($result);

		$count=mysql_num_rows($result);

		$salt = $row[3];
		$original_password = $row[2];

		$hash = hash('sha256', $_POST['password']);
		$input_password = hash('sha256', $salt . $hash);

		// To protect MySQL injection (more detail about MySQL injection)
		$input_password = stripslashes($input_password);
		$input_password = mysql_real_escape_string($input_password);
		
		if($count==1 && $input_password == $original_password)
		{
			$_SESSION['input_username'] = $input_username;
			$_SESSION['input_password'] = $input_password;
			echo "<script type='text/javascript'>alert('Login successfully!')</script>";
		}
		else
			echo "<script type='text/javascript'>alert('Wrong email or password!')</script>";
		header("location:index1.php");
	}
?>

	<body>
		

		<div style="padding: 10px; border: 1px solid black" >
		
		<div class="signup">
			<nav>
				<ul>
					<? if(isset($_SESSION['input_username'])) : ?>
					    <li>
					    	<a id="login-trigger" href="#">
					    		Welcome, <? echo $_SESSION['input_username']; ?>!
					    	</a>
					    	<div id="login-content">
					    <form method="POST" action="profile.php">
					    	<button>Profile</button>
					    </form>
					    <form method="POST" action="logout.php">
					    	<button>Log Out</button>
					    </form>
					  </div>      
					    </li>
					<? else : ?>
					<li id="login">
					  <a id="login-trigger" href="#">
					    Log in <span></span>
					  </a>
					  <div id="login-content">
					    <form name="form2" method="POST" ACTION="index1.php">
					      <fieldset id="inputs">
					        <input id="username" type='text' name='username' placeholder="Your username" maxlength="20" value="" required>   
					        <input id="password" type='password' name='password' placeholder="Password" maxlength="16" value="" required>
					      </fieldset>
					      <fieldset id="actions">
					        <input type="submit" id="submit" value="Log in">
					        <label><input type="checkbox" checked="checked"> Keep me signed in</label>
					      </fieldset>
					    </form>
					  </div>                     
					</li>
					<li id="signup">
					  <a href="signup.php">Sign up FREE</a>
					</li>
					<? endif; ?>
				</ul>
			</nav>
		</div>

			<h1> MOOCentral </h1>
			<table id="mooTest" class="dataTable" cellpadding="0" cellspacing="0" border="0" class="display">
				<thead>
					<tr>
						<th> TITLE </th>
						<th> rate </th>
						<th> start_date </th>
						<th> course_length </th>
						<th> course_image </th>
						<th> site </th>
						<th> profname </th>
						<th> profimage </th>
					</tr>
				</thead>
				<tbody>
					<?php
						while($row = mysqli_fetch_array($data)){
							echo "<tr>";
							echo "<td><a href=\"" . "page.php?ref=" . $row['course_id'] . "\" target=\"_blank\">" . $row['title'] . "</a></td>";
							echo "<td><input type=\"button\" value=\"Up\" onclick=\"rate(" . $row['course_id'] . ", 'up')\"/> <span id=\"rate_count_" .  $row['course_id'] . "\">" . $row['rate'] . "</span> <input type=\"button\" value=\"Down\" onclick=\"rate(" . $row['course_id'] . ", 'down')\"/></td>";
							echo "<td>" . $row['start_date'] . "</td>";
							echo "<td>" . $row['course_length'] . "</td>";
							echo "<td><image src=\"" . $row['course_image'] . "\" alt=\"missing course image\" height=\"100\" width=\"100\"></td>";
						//	echo "<td>" . $row['category'] . "</td>";
							echo "<td>" . $row['site'] . "</td>";
							echo "<td>" . $row['profname'] . "</td>";
							echo "<td><image src=\"" . $row['profimage'] . "\" alt=\"missing image\" height=\"100\" width=\"100\"></td>";

							echo "</tr>";
						}

					?>

				</tbody>
			</table>
	</body>
	</html>





