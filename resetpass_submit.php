<?php
session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
   
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
//$_SESSION['LAST_ACTIVITY'] = time();



if(isset($_SESSION['uid'])){

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$uid=$_SESSION['uid'];
$user=$_SESSION['user'];

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if($user == 'student'){
	
$sql="select pass from student where regno='$uid';";
}
else{
	
$sql="select pass from faculty where id='$uid';";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {

	$row=$result->fetch_assoc();
	if($_POST['cpass'] == $row['pass']){
		if($_POST['pass'] == $_POST['ccpass']){
			
			$passs=$_POST['pass'] ;
			$sql="update $user SET pass='$passs' where ".($user=='student'?'regno':'id')." ='$uid';";
					if ($conn->query($sql) === TRUE) {
		   			 echo "Password updated";
					} 
					else
					 {
		    		echo "DB Error: ". $conn->error;
					}
		}
		else
			echo "New password and confirm password doesn't match";

	}
	else
	echo "Wrong password";

}
}
else
{
	echo "Session expired, Login again and try again";
}

?>