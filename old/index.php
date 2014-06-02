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

			function rate(id, added)
			{
	   			$.ajax({
					type: 'POST',
	   				url: 'rating.php',
					data: { course_id: id, ponone: added },
					success : function(response) {
						if (response == "guest") {
							alert("You must log in before rating courses.");
						} else if (response == "success") {
	   						$('.rate_count_' + id).html(parseInt($('.rate_count_' + id).html(), 10) + added);
	   					}
					},
					error : function(jqXHR, textStatus, errorThrown){
						alert("Request Failed. Please try again later.");
					}
				});
			}

 		</script>

	</head>







	

<!--

	<div align="center">

	 <a href="data.php">Testing Purposes page</a> 

	</div>

-->



<?php
	
	session_start();

	include('connector.php');
	////// Get all results.
	//$data = mysqli_query($con, "Select * from course_data join coursedetails join rating where coursedetails.course_id = course_data.id");
	////// Get a small range of results.
	//$data = mysqli_query($con, "Select * from course_data natural join coursedetails natural join rating limit 1543");
	$data = mysqli_query($con, "select * from rating inner join (Select course_image, title, start_date, course_length, site, profname, profimage, course_id from course_data inner join coursedetails where coursedetails.course_id = course_data.id group by long_desc) j where rating.course_id = j.course_id");
?>



	<body>

		<div style="padding: 10px; border: 1px solid black" >

		<?php if(!isset($_SESSION['sess_user_id'])) { ?>

		<div class="signup">

			<nav>

				<ul>

					<li id="login">

					  <a id="login-trigger" href="#">

					    Log in <span></span>

					  </a>

					  <div id="login-content">

					    <form name="login" action="login.php" method="post">

					      <fieldset id="inputs">

					        <input id="username" type="text" name="username" placeholder="Your username" required>   

					        <input id="password" type="password" name="password" placeholder="Password" required>

					      </fieldset>

					      <fieldset id="actions">

					        <input type="submit" id="submit" value="Log in">

					        <label><input type="checkbox" checked="checked"> Keep me signed in</label>

					      </fieldset>

					    </form>

					  </div>                     

					</li>

					<li id="signup">

					  <a href="registration.html">Sign up FREE</a>

					</li>

				</ul>

			</nav>

		</div>

		<?php } else { ?>

		<div class="signedin">

			<p>Welcome, <a href="profile.php"><?php echo $_SESSION['sess_username'] ?></a></p>

			<p><a href="logout.php">Logout</a></p>

		</div>

		<?php } ?>



			<h1> MOOCentral </h1>

			<table id="mooTest" class="dataTable" cellpadding="0" cellspacing="0" border="0" class="display">

				<thead>

					<tr>

						<th>  </th>
						
						<th> Title </th>

						<th> Rating </th>

						<th> Start Date </th>

						<th> Course Length </th>

						<th> Source </th>

						<th> Professor </th>

						<th>  </th>

					</tr>

				</thead>

				<tbody>

					<?php

						while($row = mysqli_fetch_array($data)){

							echo "<tr>";

							echo "<td><image src=\"" . $row['course_image'] . "\" alt=\"missing course image\" height=\"100\" width=\"100\"></td>";

							echo "<td><a href=\"" . "page.php?ref=" . $row['course_id'] . "\" target=\"_blank\">" . $row['title'] . "</a></td>";

							echo '<td nowrap><input style="
								background-image: url(img/thumbs_up.png);
								background-color: transparent; 
								background-repeat: no-repeat; 
								background-position: 0px 0px; 
								border: none;  
								cursor: pointer;    
								height: 24px; 
								padding-left: 24px;   
								vertical-align: middle; 
								" 
								type="button" onclick="rate(' . 
								$row['course_id'] . ', 1)"/><span style="margin-right: 8px;" class="rate_count_' .  
								$row['course_id'] . '">' . $row['rate'] . 
								'</span><input style="
								background-image: url(img/thumbs_down.png);
								background-color: transparent; 
								background-repeat: no-repeat; 
								background-position: 0px 0px; 
								border: none;  
								cursor: pointer;    
								height: 24px; 
								padding-left: 24px;   
								vertical-align: middle; 
								" type="button" onclick="rate(' . 
								$row['course_id'] . ', -1)"/></td>';

							echo "<td>" . $row['start_date'] . "</td>";

							echo '<td nowrap>' . $row['course_length'] . "</td>";

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











