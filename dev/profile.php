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
		<!--[if lte IE 8]><script src="js/profile/html5shiv.js"></script><![endif]-->
		<script src="js/profile/jquery.min.js"></script>
		<script src="js/profile/skel.min.js"></script>
		<script src="js/profile/skel-panels.min.js"></script>
		<script src="js/profile/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/profile/skel-noscript.css" />
			<link rel="stylesheet" href="css/profile/style.css" />
			<link rel="stylesheet" href="css/profile/style-wide.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/profile/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/profile/ie8.css" /><![endif]-->
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
								<a href="#" class="button scrolly">Edit</a>
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
										while($row = mysqli_fetch_array($courseData)){
											if(in_array($row['course_id'], $course_list)){
												echo "<tr>";
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
							
							<p>Vitae natoque dictum etiam semper magnis enim feugiat convallis convallis
							egestas rhoncus ridiculus in quis risus amet curabitur tempor orci penatibus.
							Tellus erat mauris ipsum fermentum etiam vivamus eget. Nunc nibh morbi quis 
							fusce hendrerit lacus ridiculus.</p>
						
							<div class="row">
								<div class="4u">
									<article class="item">
										<a href="http://pixabay.com/en/motherboard-electric-computer-232515/?oq=computer" class="image full"><img src="images/motherboard.jpg" alt="" /></a>
										<header>
											<h3>Computers</h3>
										</header>
									</article>
									<article class="item">
										<a href="http://pixabay.com/en/space-shuttle-lift-off-liftoff-nasa-992/?oq=science" class="image full"><img src="images/space-shuttle.jpg" alt="" /></a>
										<header>
											<h3>Science</h3>
										</header>
									</article>
								</div>
								<div class="4u">
									<article class="item">
										<a href="http://pixabay.com/en/rome-italy-colosseum-inside-233460/?oq=history" class="image full"><img src="images/rome.jpg" alt="" /></a>
										<header>
											<h3>History</h3>
										</header>
									</article>
									<article class="item">
										<a href="http://pixabay.com/en/writing-cursive-pen-math-calculus-104091/?oq=math" class="image full"><img src="images/writing.jpg" alt="" /></a>
										<header>
											<h3>Writing</h3>
										</header>
									</article>
								</div>
								<div class="4u">
									<article class="item">
										<a href="http://pixabay.com/en/euphonium-brass-instrument-93872/?oq=music" class="image full"><img src="images/euphonium.jpg" alt="" /></a>
										<header>
											<h3>Arts</h3>
										</header>
									</article>
									<article class="item">
										<a href="http://pixabay.com/en/forest-trees-ecology-environment-272595/?oq=environment" class="image full"><img src="images/forest.jpg" alt="" /></a>
										<header>
											<h3>Environment</h3>
										</header>
									</article>
								</div>
							</div>

						</div>
					</section>

				<!-- Reviews -->
					<section id="about" class="three">
						<div class="container">

							<header>
								<h2>Reviews</h2>
							</header>
							
							<p>Tincidunt eu elit diam magnis pretium accumsan etiam id urna. Ridiculus 
							ultricies curae quis et rhoncus velit. Lobortis elementum aliquet nec vitae 
							laoreet eget cubilia quam non etiam odio tincidunt montes. Elementum sem 
							parturient nulla quam placerat viverra mauris non cum elit tempus ullamcorper 
							dolor. Libero rutrum ut lacinia donec curae mus vel quisque sociis nec 
							ornare iaculis.</p>

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