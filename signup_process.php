<?php
session_start();
include("db.php");
$pagename="Your Sign Up Results"; //Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>".$pagename."</title>"; //display name of the page as window title
echo "<body>";
include ("headfile.html"); //include header layout file
echo "<h4>".$pagename."</h4>"; //display name of the page on the web page

//capture the values entered in the form using the $_POST superglobal variable
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$address=$_POST['address'];
$pcode=$_POST['pcode'];
$tel=$_POST['tel'];
$eadd=$_POST['eadd'];
$pasw=$_POST['pasw'];
$cpasw=$_POST['cpasw'];

//if the mandatory fields are not empty
if(!empty($fname) && !empty($lname) && !empty($address) && !empty($pcode) && !empty($tel) && !empty($eadd) && !empty($pasw) && !empty($cpasw)){
	//if the 2 entered passwords do not match
	if($pasw!=$cpasw){
		echo"<p><b>Sign-up failed!</b> </t>";
		echo"<p>";
		echo"<p>Passwords do not match";
		echo"<br>Make sure you enter them correctly";
		echo"<p>";
		echo"<p>Go back to</t> <a href ='signup.php'>sign Up</a>";
	}
	else{
	
		//define regular expression
		//if email matches the regular expression
		$regex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
		if(preg_match($regex,$eadd)){
			//Write SQL query to insert a new user into users table and execute SQL query
			//Execute INSERT INTO SQL query
			$SQL = "INSERT INTO users (userFName, userSName, userAddress, userPostCode, userTelNo, userEmail, userPassword) VALUES ('$fname', '$lname', '$address', '$pcode', '$tel', '$eadd', '$pasw')";
			$exeSQL=mysqli_query($conn, $SQL);
			//Return the SQL execution error number using the error detector (hint: use mysql_errno)
			$errno=mysqli_errno($conn);
			
			//If the error detector returns the number 0, everything is fine
			if($errno == 0){
				//Display registration confirmation message
				//Display a link to login page
				echo"<p><b>Sign-up successful!</b></t>";
				echo"<p>To continue </t><a href='login.php'>Login</a>";
			}
			else{
				//if the error detector does return the number 0, there is a problem
				if($errno != 0){
					//Display generic error message
					//if error detector returned number 1062 i.e. unique constraint on the email is breached
					if($errno == 1062){
						echo"<p><b>Sign-up failed!</b> </t>";
						echo"<p>";
						echo"<p>Email already in use";
						echo"<br>You may be already registered or try another email address";
						echo"<p>";
						echo"<p>Go back to</t> <a href ='signup.php'>sign Up</a>";
					}
					//Display invalid characters error message & display a link back to signup page
					if($errno == 1064){
						echo"<p><b>Sign-up failed!</b> </t>";
						echo"<p>";
						echo"<p>Invalid characters entered in the form";
						echo"<br>Make sure you avoid the following characters:apostrophes['], backslashes [\], etc...";
					}
				} 
			} 

		}
		else{
			echo"<p><b>Sign-up failed!</b> </t>";
			echo"<p>";
			echo"<p>Email not valid";
			echo"<br>Make sure you enter a correct email address";
			echo"<p>";
			echo"<p>Go back to</t> <a href ='signup.php'>sign Up</a>";
			} 
		} 
}
else{
	echo"<p><b>Sign-up failed!</b> </t>";
	echo"<p>";
	echo"<p>Your signup form is incomplete and all fields are mandatory";
	echo"<br>Make sure you f all the required details";
	echo"<p>";
	echo"<p>Go back to</t> <a href ='signup.php'>sign Up</a>";
}

include("footfile.html"); //include head layout
echo "</body>";
?>