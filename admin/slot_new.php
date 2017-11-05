<?php
session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();

if(isset($_SESSION['uid'])){
    $uid=$_SESSION['uid'];

    $user = $_SESSION['user'];
    if($user != 'admin')
        header("Location: ../usererror.php");

$slot_no = !empty($_POST["slot_no"]) ? $_POST["slot_no"] : null;
$timing = !empty($_POST["timing"]) ? $_POST["timing"] : null;



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Check connection
$sql = "INSERT INTO slot (no,timing) values ('$slot_no','$timing');";
if ($conn->query($sql) === TRUE) {
	
	$sql2 = "ALTER TABLE class ADD ".$slot_no." VARCHAR(3) NOT NULL DEFAULT 'No';";
	
	if ($conn->query($sql2) === TRUE){
    echo "<strong>Success: </strong>". $slot_no ." was added successfully";
	}
	else {
    echo "<strong>Error: </strong>". $conn->errno;
	}

}
else {
    echo "<strong>Error: </strong>This slot already exist";
}

$conn->close();

}
else
header("Location: ../sessionerror.php");

?>

