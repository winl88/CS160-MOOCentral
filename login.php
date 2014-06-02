<?php
	session_start();
?>
<!DOCTYPE HTML>
<!--
	Telephasic 1.1 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>MOOCentral Login</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,600" rel="stylesheet" type="text/css" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-n1.css" />
		</noscript>
	</head>
	<body class="no-sidebar">

		<!-- Header Wrapper -->
			<div id="header-wrapper">
						
				<!-- Header -->
					<div id="header" class="container">
						
						<!-- Logo -->
							<h1 id="logo"><a href="index.php">MOOCentral</a></h1>
						
						<!-- Nav -->
							<nav id="nav">
								<ul>																	<li><a href="courses.php">Courses</a></li>
									<li class="break">
										<?php if(!isset($_SESSION['sess_user_id'])) { ?>
										<a href="login.php">Login</a>
										<?php } else { ?>
										<a href=""><?php echo $_SESSION['sess_username'] ?></a>
										<ul>
											<li><a href="profile.php">Profile</a></li>
											<li><a href="profile.php#portfolio">Favorites</a></li>
											<li><a href="logout.php">Logout</a></li>
										</ul>
										<?php } ?>
									</li>
								</ul>
							</nav>

					</div>
			</div>

		<!-- Main Wrapper -->
			<div class="wrapper">
			
				<div class="container" style="margin:0 auto; text-align:center">
					<h2 style="margin-bottom:10px">User Login</h2>
					<form name="login" action="login_check.php" method="post">
						<fieldset id="inputs">
							<input id="username" type="text" name="username" placeholder="Username" style="margin-bottom:5px"></br> 
							<input id="password" type="password" name="password" placeholder="Password" style="margin-bottom:5px">
						</fieldset>
						<fieldset id="actions">
							<label><input type="checkbox" checked="checked" style="margin-bottom:15px"> Keep me signed in</label>
							<input type="submit" id="submit" value="Log in">
						</fieldset>
					</form>
				</div>
				
			</div>

		<!-- Footer Wrapper -->
			<div id="footer-wrapper">

				<!-- Copyright -->
					<div id="copyright" class="container">
						<ul class="menu">
							<li>&copy; 2014 MOOCentral. All rights reserved.</li>
							<li>Design: <a href="http://html5up.net/">HTML5 UP</a></li>
						</ul>
					</div>

			</div>

	</body>
</html>