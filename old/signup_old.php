<?PHP

$uname = "";
$pword = "";
$errorMessage = "";
$first = "";
$last = "";
$gender = "";
$dobMonth = "";
$dobDay = "";
$dobYear = "";
$color = "";
$interests = "";
$languages = "";
$comments = "";

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
	$first = $_POST['firstname'];
	$last = $_POST['lastname'];
	$gender = $_POST['gender'];
	$dobMonth = $_POST['dobMonth'];
	$dobDay = $_POST['dobDay'];
	$dobYear = $_POST['dobYear'];
	$color = $_POST['color'];
	$interests = $_POST['interests'];
	$languages = $_POST['languages'];
	$comments = $_POST['comments'];

	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);
	$first = htmlspecialchars($first);
	$last = htmlspecialchars($last);
	$gender = htmlspecialchars($gender);
	$dobMonth = htmlspecialchars($dobMonth);
	$dobDay = htmlspecialchars($dobDay);
	$dobYear = htmlspecialchars($dobYear);
	$color = htmlspecialchars($color);
	$interests = htmlspecialchars($interests);
	$languages = htmlspecialchars($languages);
	$comments = htmlspecialchars($comments);


	$con = mysqli_connect("localhost", "sjsucsor_s2g414s", "abcd#1234", "sjsucsor_160s2g42014s");
	//$con = mysqli_connect("localhost", "root", "", "moocs160");	
	if(mysqli_connect_errno()){
		echo "failed to connect to MySQL: " . mysqli_connect_errno();
	}

	$hash = hash('sha256', $pword);
 
	function createSalt()
	{
    		$text = md5(uniqid(rand(), true));
    		return substr($text, 0, 3);
	}
 
	$salt = createSalt();
	$password = hash('sha256', $salt . $hash);

	$SQL2 = "INSERT INTO `profile` (`user`, `password`, `salt`, `first`, `last`, `gender`, `month`, `day`, `year`, `color`, `interests`, `languages`, `comments`) 
			VALUES ('$uname', '$password', '$salt', '$first', '$last', '$gender', '$dobMonth', '$dobDay', '$dobYear', '$color', '$interests', '$languages', '$comments')";
	
	if (!mysqli_query($con,$SQL2)) {
            die('Error: ' . mysqli_error($con));
        }
	mysqli_close($con);


	$uLength = strlen($uname);
	$pLength = strlen($pword);

	if ($uLength >= 5 && $uLength <= 30) {
		$errorMessage = "";
	}
	else {
		$errorMessage = $errorMessage . "Username must be between 10 and 20 characters" . "<BR>";
	}

	if ($pLength >= 5 && $pLength <= 30) {
		$errorMessage = "";
	}
	else {
		$errorMessage = $errorMessage . "Password must be between 8 and 16 characters" . "<BR>";
	}


	if ($errorMessage == "") {

/*
	$user_name = "root";
	$pass_word = "";
	$database = "moocs160";
	$server = "localhost";
*/

	$user_name = "sjsucsor_s2g414s";
	$pass_word = "abcd$1234";
	$database = "sjsucsor_160s2g42014s";
	$server = "localhost";


	$db_handle = mysql_connect($server, $user_name, $pass_word);
	$db_found = mysql_select_db($database, $db_handle);

	if ($db_found) {

		$uname = quote_smart($uname, $db_handle);
		$pword = quote_smart($pword, $db_handle);

		$SQL = "SELECT * FROM login WHERE L1 = $uname";
		$result = mysql_query($SQL);
		$num_rows = mysql_num_rows($result);

		if ($num_rows > 0) {
			$errorMessage = "Username already taken";
		}
		
		else {

			$SQL = "INSERT INTO login (L1, L2) VALUES ($uname, $pword)";

			
			$result = mysql_query($SQL);
			


			mysql_close($db_handle);

			//session_start();
			//$_SESSION['login'] = "1";

			header ("Location: index.php");

		}

	}
	else {
		$errorMessage = "Database Not Found";
	}

	}

}


?>

	<html>
	<head>
	<title>Sign Up page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script language="javascript" type="text/javascript" src="niceforms.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="niceforms-default.css" />
	</head>
	<body>

<div id="container">
<form action="signup.php" method="POST" class="niceform">
	<fieldset>
    	<legend>Personal Info</legend>
        <dl>
        	<dt><label for="username">Username:</label></dt>
            <dd><input type="text" name="username" id="username" size="32" maxlength="128" /></dd>
        </dl>
        <dl>
        	<dt><label for="password">Password:</label></dt>
            <dd><input type="password" name="password" id="password" size="32" maxlength="32" /></dd>
        </dl>
        <dl>
        	<dt><label for="firstname">First Name:</label></dt>
            <dd><input type="text" name="firstname" id="firstname" size="32" maxlength="32" /></dd>
        </dl>
   		<dl>
        	<dt><label for="lastname">Last Name:</label></dt>
            <dd><input type="text" name="lastname" id="lastname" size="32" maxlength="32" /></dd>
        </dl>
        <dl>
        	<dt><label for="gender">Gender:</label></dt>
            <dd>
            	<select size="1" name="gender" id="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Don't Ask">Don't Ask</option>
            	</select>
            </dd>
        </dl>
        <dl>
        	<dt><label for="dobMonth">Date of Birth:</label></dt>
            <dd>
            	<select size="1" name="dobMonth" id="dobMonth">
                	<option value="Jan">Jan</option>
                    <option value="Feb">Feb</option>
                    <option value="Mar">Mar</option>
                    <option value="Apr">Apr</option>
                    <option value="May">May</option>
                    <option value="Jun">Jun</option>
                    <option value="Jul">Jul</option>
                    <option value="Aug">Aug</option>
                    <option value="Sep">Sep</option>
                    <option value="Oct">Oct</option>
                    <option value="Nov">Nov</option>
                    <option value="Dec">Dec</option>
                </select>
                <select size="1" name="dobDay" id="dobDay">
                	<option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                </select>
                <select size="1" name="dobYear" id="dobYear">
                	<option value="2000">2000</option>
                    <option value="1999">1999</option>
                    <option value="1998">1998</option>
                    <option value="1997">1997</option>
                    <option value="1996">1996</option>
                    <option value="1995">1995</option>
					<option value="1994">1994</option>
					<option value="1993">1993</option>
					<option value="1992">1992</option>
					<option value="1991">1991</option>
					<option value="1990">1990</option>
					<option value="1989">1989</option>
					<option value="1988">1988</option>
					<option value="1987">1987</option>
					<option value="1986">1986</option>
					<option value="1985">1985</option>
					<option value="1984">1984</option>
					<option value="1983">1983</option>
					<option value="1982">1982</option>
					<option value="1981">1981</option>
					<option value="1980">1980</option>
					<option value="1979">1979</option>
					<option value="1978">1978</option>
					<option value="1977">1977</option>
					<option value="1976">1976</option>
					<option value="1975">1975</option>
					<option value="1974">1974</option>
					<option value="1973">1973</option>
					<option value="1972">1972</option>
					<option value="1971">1971</option>
					<option value="1970">1970</option>
					<option value="1969">1969</option>
					<option value="1968">1968</option>
					<option value="1967">1967</option>
					<option value="1966">1966</option>
					<option value="1965">1965</option>
					<option value="1964">1964</option>
					<option value="1963">1963</option>
					<option value="1962">1962</option>
					<option value="1961">1961</option>
					<option value="1960">1960</option>
					<option value="1959">1959</option>
					<option value="1958">1958</option>
					<option value="1957">1957</option>
					<option value="1956">1956</option>
					<option value="1955">1955</option>
					<option value="1954">1954</option>
					<option value="1953">1953</option>
					<option value="1952">1952</option>
					<option value="1951">1951</option>
					<option value="1950">1950</option>
                </select>
            </dd>
        </dl>
    </fieldset>
    <fieldset>
    	<legend>Preferences</legend>
        <dl>
        	<dt><label for="color">Favorite Color:</label></dt>
            <dd>
            	<input type="radio" name="color" id="colorBlue" value="Blue" /><label for="colorBlue" class="opt">Blue</label>
                <input type="radio" name="color" id="colorRed" value="Red" /><label for="colorRed" class="opt">Red</label>
                <input type="radio" name="color" id="colorGreen" value="Green" /><label for="colorGreen" class="opt">Green</label>
            </dd>
        </dl>
        <dl>
        	<dt><label for="interests">Interests:</label></dt>
            <dd>
                <input type="radio" name="interests" id="interestsNews" value="News" /><label for="interestsNews" class="opt">News</label>
                <input type="radio" name="interests" id="interestsSports" value="Sports" /><label for="interestsSports" class="opt">Sports</label>
                <input type="radio" name="interests" id="interestsEntertainment" value="Entertainment" /><label for="interestsEntertainment" class="opt">Entertainment</label>
                <input type="radio" name="interests" id="interestsCars" value="Cars" /><label for="interestsCars" class="opt">Automotive</label>
                <input type="radio" name="interests" id="interestsTechnology" value="Technology" /><label for="interestsTechnology" class="opt">Technology</label>
            </dd>
        </dl>
        <dl>
        	<dt><label for="languages">Languages:</label></dt>
            <dd>
            	<select size="4" name="languages" id="languages" multiple="single">
                	<option value="English">English</option>
                    <option value="French">French</option>
                    <option value="Spanish">Spanish</option>
                    <option value="Italian">Italian</option>
                    <option value="Chinese">Chinese</option>
                    <option value="Japanese">Japanese</option>
                    <option value="Russian">Russian</option>
                </select>
            </dd>
        </dl>
    </fieldset>
    <fieldset>
    	<legend>Comments</legend>
        <dl>
        	<dt><label for="comments">Message:</label></dt>
            <dd><textarea name="comments" id="comments" rows="5" cols="60"></textarea></dd>
        </dl>
        <dl>
        	<dt><label for="upload">Upload a File:</label></dt>
            <dd><input type="file" name="upload" id="upload" /></dd>
        </dl>
    </fieldset>
    <fieldset class="action">
        <a href="index.php">Cancel</a>
    	<input type="submit" name="submit" id="submit" value="Submit" />
    </fieldset>
</form>
<!-- <p id="footer">Niceforms v.2.0<br />&copy;Lucian Slatineanu - <a href="http://www.emblematiq.com/">Emblematiq</a><br />Last update: Nov 13 2008</p> -->
</div>

	</body>
	</html>
