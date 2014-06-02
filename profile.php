<?php
	session_start();
    if (!isset($_SESSION['sess_user_id']))
    header("Location: index.php");
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
		<noscript>
			<link rel="stylesheet" href="css/profile/skel-noscript.css" />
			<link rel="stylesheet" href="css/profile/style.css" />
			<link rel="stylesheet" href="css/profile/style-wide.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css" /><![endif]-->
		<script type="text/javascript">
			function removeFavorites(id, opt)
			{
				var result=confirm("Remove Class?");
				if (result==true)
				{
		   			$.ajax({
						type: 'POST',
		   				url: 'favorite.php',
						data: { course_id: id, option: opt },
						success : function(response) {
							if (response == "guest") {
								alert("You must log in before adding courses to favorites.");
		   					} else if (response == "removed") {
		   						window.location.reload();
		   					} else {
							}
						},
						error : function(jqXHR, textStatus, errorThrown){
							alert("Request Failed. Please try again later.");
						}
					});
		   		}
			}

			function modifyReview(id, opt)
			{
				if(opt == 1)
					var review = prompt("Adding Review:");
				else if(opt == 2)
					var review = prompt("Updating Review:");

				if(review != null)
				{
					$.ajax({
						type: 'POST',
		   				url: 'review.php',
						data: { course_id: id, option: opt, review: review },
						success : function(response) {
							if (response == "added") {
		   						alert("Added successfully!");
		   						window.location.reload();
		   					} else if(response == "updated") {
		   						alert("Updated successfully!");
		   						window.location.reload();
							} else if(response == "empty") {
								alert("Cannot be empty!");
							}
						},
						error : function(jqXHR, textStatus, errorThrown){
							alert("Request Failed. Please try again later.");
						}
					});
				}
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

		$query_reviews = "SELECT title, review, course_id
				FROM reviews JOIN course_data
				WHERE reviews.course_id = course_data.id AND reviews.user_id = '$user_id'";
		$reviewData = mysqli_query($con, $query_reviews)
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
								<li><a href="#portfolio" id="portfolio-link" class="skel-panels-ignoreHref"><span class="fa fa-star">Favorites</span></a></li>
								<li><a href="#about" id="about-link" class="skel-panels-ignoreHref"><span class="fa fa-pencil">Reviews</span></a></li>
								<li><a href="courses.php" id="about-link" class="skel-panels-ignoreHref"><span class="fa fa-list">Back to Courses</span></a></li>
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
								<h2 class="alt">Personal Information</h2>
							</header>
							
							<form name="userprofile" action="updateprofile.php" method="post">
							    <table width="510" border="0">
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
								</table>
							</form>

							<footer>
								<a href="editProfile.php" class="button scrolly">Edit</a>
							</footer>

						</div>
					</section>
					
				<!-- Favorites -->
					<section id="portfolio" class="two">
						<div class="container">
					
							<header>
								<h2>Favorites</h2>
							</header>
							
							<table id="favorites" class="dataTables" cellpadding="0" cellspacing="0" border="0" class="display" style="font-size:90%">
								<thead>
									<tr>
										<th> </th>
										<th> </th>
										<th> Title </th>
										<th> Start Date </th>
										<th> Course Length </th>
										<th> Source </th>
										<th> Professor </th>
										<th> </th>
									</tr>
								</thead>
								<tbody>
									<?php
										function checkAddedReview($user_id, $course_id)
										{
											include('connector.php');

											$check = mysqli_query($con, "SELECT * FROM reviews WHERE user_id='$user_id' AND course_id='$course_id'");
											$do_check = mysqli_num_rows($check);

											if($do_check == 0)
												return true;
											else
												return false;
										}
										while($row = mysqli_fetch_array($courseData)){
											if(in_array($row['course_id'], $course_list)){
												echo "<tr>";
												echo "<td style=\"vertical-align:middle\"><button onclick=\"removeFavorites(" . $row['course_id'] . ", 2)\">Remove</button>";
												if(checkAddedReview($_SESSION['sess_user_id'], $row['course_id']))
													echo "<button onclick=\"modifyReview(" . $row['course_id'] . ", 1)\">Add Review</button>";
												echo "</td>";
												echo "<td style=\"vertical-align:middle\"><image src=\"" . $row['course_image'] . "\" alt=\"missing course image\" height=\"100\" width=\"100\"></td>";
												echo "<td style=\"vertical-align:middle\" width=\"500px\"><a href=\"" . "page.php?ref=" . $row['course_id'] . "\" target=\"_blank\">" . $row['title'] . "</a></td>";
												echo "<td style=\"vertical-align:middle\">" . $row['start_date'] . "</td>";
												echo "<td style=\"vertical-align:middle\">" . $row['course_length'] . "</td>";
											//	echo "<td>" . $row['category'] . "</td>";
												echo "<td style=\"vertical-align:middle\">" . $row['site'] . "</td>";
												echo "<td style=\"vertical-align:middle\">" . $row['profname'] . "</td>";
												echo "<td style=\"vertical-align:middle\"><image src=\"" . $row['profimage'] . "\" alt=\"missing image\" height=\"100\" width=\"100\"></td>";
												echo "</tr>";
											}
										}
										mysqli_close($con);
									?>
								</tbody>
							</table>
						</div>
					</section>

				<!-- Reviews -->
					<section id="about" class="three">
						<div class="container">

							<header>
								<h2>Reviews</h2>
							</header>

							<table class="dataTables" cellpadding="0" cellspacing="0" border="0" class="display" style="font-size:70%">
								<thead>
									<?php
										$check = mysqli_num_rows($reviewData);
										if($check > 0)
										echo "<tr>
											<th> Title </th>
											<th> Review </th>
											<th> </th>
											</tr>";
									?>
								</thead>
								<tbody>
									<?php										
										while($row = mysqli_fetch_array($reviewData)){
												echo "<tr>";
												echo "<td width=\"400px\">" . $row['title'] . "</td>";
												echo "<td >" . $row['review'] . "</td>";
												echo "<td ><button onclick=\"modifyReview(" . $row['course_id'] . ", 2)\">Update</button></td>";
												echo "</tr>";
										}
										mysqli_close($con);
									?>
								</tbody>
							</table>
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