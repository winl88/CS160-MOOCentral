<?php
	session_start();
?>
<!DOCTYPE HTML>
<!--
	Prologue 1.2 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>MOOCentral User Profile</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600" rel="stylesheet" type="text/css" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/profile/jquery.min.js"></script>
		<script src="js/profile/skel.min.js"></script>
		<script src="js/profile/skel-panels.min.js"></script>
		<script src="js/profile/init.js"></script>	
		<script src="js/gen_validatorv4.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/profile/skel-noscript.css" />
			<link rel="stylesheet" href="css/profile/style.css" />
			<link rel="stylesheet" href="css/profile/style-wide.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<script>
			function removeFavorites(id, opt)
			{
	   			$.ajax({
					type: 'POST',
	   				url: 'favorite.php',
					data: { course_id: id, option: opt },
					success : function(response) {
						if (response == "guest") {
							alert("You must log in before adding courses to favorites.");
	   					} else if (response == "removed") {
	   						alert("Removed successfully!");
	   						window.location.reload();
	   					} else {
						}
					},
					error : function(jqXHR, textStatus, errorThrown){
						alert("Request Failed. Please try again later.");
					}
				});
			}
		</script>
	</head>
	
	<?php
		include('connector.php');

		$username = $_SESSION['sess_username'];
		$user_id = $_SESSION['sess_user_id'];
		$username = mysqli_real_escape_string($con, $username);

		$query = "SELECT username, fname, lname, email, password
				FROM members
				WHERE username = '$username';";

		$result = mysqli_query($con, $query);
		$userData = mysqli_fetch_array($result, MYSQL_ASSOC);
		
		$query_courses = "SELECT course_id
				FROM member_faves
				WHERE member_id = '$user_id';";
				
		$courses = mysqli_query($con, $query_courses);
		$course_list = array();
		while($courseData = mysqli_fetch_array($courses)){
			$course_list[] = $courseData['course_id'];
		}
		
		$query_faves = "SELECT *
				FROM course_data
				JOIN coursedetails
				WHERE coursedetails.course_id = course_data.id";
		
		$courseData = mysqli_query($con, $query_faves);
	?>
	
	<body>
					
		<!-- Header -->
			<div id="header" class="skel-panels-fixed">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							<h1 id="title"><?php echo $userData['fname'] . " " . $userData['lname'] ?></h1>
							<span class="byline">New Recruit</span>
						</div>

					<!-- Nav -->
						<nav id="nav">
							<!--
							
								Prologue's nav expects links in one of two formats:
								
								1. Hash link (scrolls to a different section within the page)
								
								   <li><a href="#foobar" id="foobar-link" class="skel-panels-ignoreHref"><span class="fa fa-whatever-icon-you-want">Foobar</span></a></li>

								2. Standard link (sends the user to another page/site)

								   <li><a href="http://foobar.tld"><span class="fa fa-whatever-icon-you-want">Foobar</span></a></li>
							
							-->
							<ul>
								<li><a href="#top" id="top-link" class="skel-panels-ignoreHref"><span class="fa fa-user">Personal Information</span></a></li>
								<li><a href="profile.php" id="about-link" class="skel-panels-ignoreHref"><span class="fa fa-list">Back to Profile</span></a></li>
							</ul>
						</nav>
						
				</div>
				
				<div class="bottom">

					<!-- Social Icons -->
						<ul class="icons">
							<li><a href="#" class="fa fa-twitter solo"><span>Twitter</span></a></li>
							<li><a href="#" class="fa fa-facebook solo"><span>Facebook</span></a></li>
							<li><a href="#" class="fa fa-github solo"><span>Github</span></a></li>
							<li><a href="#" class="fa fa-envelope solo"><span>Email</span></a></li>
						</ul>
				
				</div>
			
			</div>

		<!-- Main -->
			<div id="main">
				<!-- Intro -->
					<section id="top" class="one">
						<div class="container">
						
							<header>
								<h2 class="alt">Edit Profile</h2>
							</header>
							
							<form id="edit_form" name="userprofile" action="updateProfile.php" method="post">
							    <table width="510" border="0">
									<tr>
										<td>First Name:</td>
										<td><input type="text" name="fname" maxlength="20" value=<?php echo $userData['fname'] ?>></td>
									</tr>
									<tr>
										<td>Last Name:</td>
										<td><input type="text" name="lname" maxlength="20" value=<?php echo $userData['lname'] ?>></td>
									</tr>
									<tr>
										<td>Email:</td>
										<td><input type="email" name="email" value=<?php echo $userData['email'] ?>></td>
									</tr>
									<tr>
										<td>Current Password:</td>
										<td><input type="password" name="oldpw" maxlength="20"></td>
									</tr>
									<tr>
										<td>New Password:</td>
										<td><input type="password" name="newpw1" maxlength="20"></td>
									</tr>
									<tr>
										<td>Confirm New Password:</td>
										<td><input type="password" name="newpw2" maxlength="20"></td>
									</tr>
								</table>

								
									<a href="profile.php" class="button scrolly">Cancel</a>
									<input type="submit" class="button scrolly" value="Save"/>
								
							</form>

							<script type="text/javascript">//<![CDATA[
									//You should create the validator only after the definition of the HTML form
									var frmvalidator  = new Validator("edit_form");

									frmvalidator.addValidation("fname","req","Please enter your First Name");
									frmvalidator.addValidation("fname","maxlen=20","Max length for FirstName is 20");
									frmvalidator.addValidation("fname","alpha","Name can contain alphabetic chars only");
									
									frmvalidator.addValidation("lname","req","Please enter your Last Name");
									frmvalidator.addValidation("lname","maxlen=20","Max length for Last Name is 20");
									frmvalidator.addValidation("lname","alpha","Name can contain alphabetic chars only");

									frmvalidator.addValidation("email","req", "Please enter your email");
									frmvalidator.addValidation("email","maxlen=50","Max length for email is 50");
									frmvalidator.addValidation("email","email");

									frmvalidator.addValidation("oldpw","req","Please enter your current password");
									
									frmvalidator.addValidation("newpw2","eqelmnt=newpw1","The new passwords do not match");
									//]]>
								</script>

						</div>
					</section>
				</div>

		<!-- Footer -->
			<div id="footer">
				
				<!-- Copyright -->
					<div class="copyright">
						<p>&copy; 2014 MOOCentral. All rights reserved.</p>
						<ul class="menu">
							<li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
						</ul>
					</div>
				
			</div>

	</body>
</html>