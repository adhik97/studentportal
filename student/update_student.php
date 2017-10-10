<?php 

session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

if(isset($_SESSION['uid'])){
$uid=$_SESSION['uid'];

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 




$name = !empty($_POST["name"]) ? $_POST["name"] : null;
$dob = !empty($_POST["dob"]) ? date("Y-m-d", strtotime($_POST["dob"])) : null;
$address = !empty($_POST["address"]) ? $_POST["address"] : null;
$phno = !empty($_POST["phno"]) ? $_POST["phno"] : 'null';
$email = !empty($_POST["email"]) ? $_POST["email"] : null;

$sql = "update student SET name='$name',dob=". ($dob==NULL ? "NULL" : "'$dob'") .",address='$address',phno=$phno,email='$email' where regno='$uid';";


if ($conn->query($sql) === TRUE) {
		   			 echo "Profile updated";
					} 
					else
					 {
		    		echo "DB Error: ". $conn->error;
					}

 $conn->close();

}
else
header("Location: ./sessionerror.php");

 ?>
