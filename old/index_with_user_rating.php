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
				var sess_id='<?= $_SESSION['sess_user_id']?>';
				if (sess_id.length > 0) {
					alert(sess_id);
		   			$.ajax({
						type: 'POST',
		   				url: 'rating_check.php',
						data: { course_id: id, user_id: sess_id },
						success : function(response) {
							alert(response);
							if (response == 'allow'){
								alert('execute vote');
					   			$.ajax({
									type: 'POST',
					   				url: 'rating.php',
									data: { course_id: id, ponone: added, user_id: sess_id },
									success : function(response) {
					   					$('.rate_count_' + id).html(parseInt($('.rate_count_' + id).html(), 10) + added);
									},
									error : function(jqXHR, textStatus, errorThrown){
										alert("Request Failed. Please try again later.");
									}
								});
							}else{
								alert('This course has been rated before.');
							}
						},
						error : function(jqXHR, textStatus, errorThrown){
							alert("Request Failed. Please try again later.");
						}
					});
				} else {
					alert("You must log in before rating courses.");
				}
			}
			
			
			
			
			
			
			
			
			
 		</script>
	</head>



	
<!--
	<div align="center">
	 <a href="data.php">Testing Purposes page</a> 
	</div>
-->

<?php
	$con = mysqli_connect("localhost", "sjsucsor_s2g414s", "abcd#1234", "sjsucsor_160s2g42014s");
	//$con = mysqli_connect("localhost", "root", "root", "moocs160");	
	if(mysqli_connect_errno()){
		echo "failed to connect to MySQL: " . mysqli_connect_errno();
	}

	$mquery = "select * from rating j1 " . 
	"join (select * from (select * from course_data where title not like '%?%' group by long_desc) A join coursedetails B where A.id = B.course_id limit 100) j2 where j1.course_id = j2.id";
	$mque="select * from (select * from course_data where title not like '%?%' group by long_desc) A join coursedetails B where A.id = B.course_id limit 100";
	$data = mysqli_query($con, "select * from rating inner join (Select course_image, title, start_date, course_length, site, profname, profimage, course_id from course_data inner join coursedetails where coursedetails.course_id = course_data.id and title not like '%?%' group by long_desc) j where rating.course_id = j.course_id
");
	//$data = mysqli_query($con, "Select * from course_data join coursedetails where coursedetails.course_id = course_data.id limit 100");
	//$data = mysqli_query($con, "Select * from course_data join coursedetails where coursedetails.course_id = course_data.id");
 
?>

	<body>
		

		<div style="padding: 10px; border: 1px solid black" >
		
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
							
							
							
							
							
							echo '<td style="white-space:nowrap;"><input style="
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
								$row['course_id'] . ', 1)"/><span style="margin-right: 10px;" class="rate_count_' .  
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





