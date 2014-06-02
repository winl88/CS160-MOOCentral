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
		<title>MOOCentral</title>
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
		<script src="js/gen_validatorv4.js"></script>
	</head>
	
	<body class="homepage">

		<!-- Header Wrapper -->
			<div id="header-wrapper">
						
				<!-- Header -->
					<div id="header" class="container">
						
						<!-- Logo -->
							<h1 id="logo"><a href="index.php">MOOCentral</a></h1>
						
						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li>
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
									<li class="break"><a href="courses.php">Courses</a></li>
								</ul>
							</nav>

					</div>
					
				<!-- Hero -->
					<section id="hero" class="container">
						<header>
							<h2>MOOCentral is your center<br />
							for all online courses</a></h2>
						</header>
						<ul class="actions">
							<li><a href="#footer-wrapper" class="button">Sign Up for FREE</a></li>
						</ul>
					</section>

			</div>

		<!-- Main Wrapper -->
			<div class="wrapper">

				<div class="container">
					<div class="row" id="main">
						<div class="12u">
					
							<!-- Content -->
								<article id="content">
									<header>
										<h2>Welcome!</h2>
										<span>Lorem ipsum dolor sit amet consectetur et sed adipiscing elit
										dolor neque semper.</span>
									</header>
									<a href="http://pixabay.com/en/san-jose-state-university-california-106865/?oq=college" class="image full"><img src="images/san-jose-state.jpg" alt="" /></a>
									<p>Ut sed tortor luctus, gravida nibh eget, volutpat odio. Proin rhoncus, sapien 
									mollis luctus hendrerit, orci dui viverra metus, et cursus nulla mi sed elit. Vestibulum 
									condimentum, mauris a mattis vestibulum, urna mauris cursus lorem, eu fringilla lacus 
									ante non est. Nullam vitae feugiat libero, eu consequat sem. Proin tincidunt neque 
									eros. Duis faucibus blandit ligula, mollis commodo risus sodales at. Sed rutrum et 
									turpis vel blandit. Nullam ornare congue massa, at commodo nunc venenatis varius. 
									Praesent mollis nisi at vestibulum aliquet. Sed sagittis congue urna ac consectetur.</p>
									<p>Mauris eleifend eleifend felis aliquet ornare. Vestibulum porta velit at elementum
									gravida nibh eget, volutpat odio. Proin rhoncus, sapien 
									mollis luctus hendrerit, orci dui viverra metus, et cursus nulla mi sed elit. Vestibulum 
									condimentum, mauris a mattis vestibulum, urna mauris cursus lorem, eu fringilla lacus 
									ante non est. Nullam vitae feugiat libero, eu consequat sem. Proin tincidunt neque 
									eros. Duis faucibus blandit ligula, mollis commodo risus sodales at. Sed rutrum et 
									turpis vel blandit. Nullam ornare congue massa, at commodo nunc venenatis varius. 
									Praesent mollis nisi at vestibulum aliquet. Sed sagittis congue urna ac consectetur.</p>
									<p>Vestibulum pellentesque posuere lorem non aliquam. Mauris eleifend eleifend 
									felis aliquet ornare. Vestibulum porta velit at elementum elementum.</p>
								</article>

						</div>
					</div>
				</div>
			</div>

		<!-- Footer Wrapper -->
			<div id="footer-wrapper">

				<!-- Footer -->
					<div id="footer" class="container">
						<header class="major">
							<h2>Sign up for MOOCentral to keep track of your courses.</h2>
							<span>Creating an account allows you to favorite courses and rate the courses you have taken.</span>
						</header>
						<div class="row">
							<section class="6u">
								<form id="reg_form" method="post" action="register.php">
									<table width="510" border="0">
										<tr>
											<td>Username:</td>
											<td><input type="text" name="username" maxlength="20"/></td>
										</tr>
										<tr>
											<td>First Name:</td>
											<td><input type="text" name="fname" maxlength="20" placeholder="John"/></td>
										</tr>
										<tr>
											<td>Last Name:</td>
											<td><input type="text" name="lname" maxlength="20" placeholder="Smith"//></td>
										</tr>
										<tr>
											<td>Email:</td>
											<td><input type="email" name="email" maxlength="50" placeholder="jsmith@email.com"//></td>
										</tr>
										<tr>
											<td>Password:</td>
											<td><input type="password" name="password1" maxlength="20"/></td>
										</tr>
										<tr>
											<td>Confirm Password:</td>
											<td><input type="password" name="password2" maxlength="20"/></td>
										</tr>
										<tr><td>&nbsp;</td></tr>
										<tr>
											<td>&nbsp;</td>
											<td><input type="submit" value="Sign Up" /></td>
										</tr>
									</table>
								</form>
								
								<script type="text/javascript">//<![CDATA[
									//You should create the validator only after the definition of the HTML form
									var frmvalidator  = new Validator("reg_form");

									frmvalidator.addValidation("username","req","Please enter a username");
									frmvalidator.addValidation("username","minlen=4","Username has to be at least 4 characters");
									frmvalidator.addValidation("username","maxlen=20","Max length for username is 20");
									frmvalidator.addValidation("username","alnum","Username can contain alphanumeric chars only");
									
									frmvalidator.addValidation("fname","req","Please enter your First Name");
									frmvalidator.addValidation("fname","maxlen=20","Max length for FirstName is 20");
									frmvalidator.addValidation("fname","alpha","Name can contain alphabetic chars only");
									
									frmvalidator.addValidation("lname","req","Please enter your Last Name");
									frmvalidator.addValidation("lname","maxlen=20","Max length for Last Name is 20");
									frmvalidator.addValidation("lname","alpha","Name can contain alphabetic chars only");

									frmvalidator.addValidation("email","req", "Please enter your email");
									frmvalidator.addValidation("email","maxlen=50","Max length for email is 50");
									frmvalidator.addValidation("email","email");

									frmvalidator.addValidation("password1","req","Please enter a password");
									frmvalidator.addValidation("password1","minlen=4","Password has to be at least 6 characters");
									frmvalidator.addValidation("password1","maxlen=20",	"Max length for password is 20");
									frmvalidator.addValidation("password1","alnum","Name can contain alphabetic chars only");
									
									frmvalidator.addValidation("password2","eqelmnt=password1","The passwords do not match");
									//]]>
								</script>
								
							</section>
						</div>
					</div>

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