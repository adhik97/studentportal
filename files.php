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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$unique_id=isset($_POST['unique_id'])?$_POST['unique_id']:null;

$sql = "select * from files where unique_id='$unique_id';";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

	$rows=array();
	while($row = $result->fetch_assoc())
		$rows[]=$row;
    $rarray = array('type' => 'success',
					 'message' => $rows);
    echo json_encode($rarray);
 }
 else{
 	$rarray = array('type' => 'error',
 				    'message' => 'No files has been uploaded' );
 	echo json_encode($rarray);
 }
$conn->close();
}

else
header("Location: /studentportal/sessionerror.php");
?>


