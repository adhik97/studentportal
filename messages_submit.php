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

    if($user == 'student')
        header("Location: ../usererror.php");

$recieve = !empty($_POST["recv"]) ? $_POST["recv"] : null;
$messageData = !empty($_POST["ann"]) ? nl2br($_POST["ann"]) : null;






$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

    $sql = "INSERT INTO messages(recieve,sent_by,messageData,time_issued) values('$recieve','". ($user == 'admin' ?'ADMIN':$uid) ."','$messageData',now());";


if($conn->query($sql) === TRUE){
	$id = $conn->insert_id;
	$sql = "select * from messages where id = '$id';";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$rarray = array('type' => 'success',
					'message' => $row);
	echo json_encode($rarray);
}
else
{
	$rarray = array('type' => 'error',
					'message' => $conn->errno); 

	echo json_encode($rarray);
}

$conn->close();


} 
else
header("Location: ../sessionerror.php");


?>