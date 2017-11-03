<?php

session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();

if(isset($_SESSION['uid'])){
$uid = $_SESSION['uid'];

if(strlen($uid) == 5){


$uid=$_SESSION['uid'];
$filename = $_POST['fname'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "select faculty_id from files JOIN course where filename = '$filename';";
$result = $conn->query($sql);

if($result->num_rows > 0){
$row = $result->fetch_assoc();

if($row['faculty_id'] == $uid){

	$path = "./uploads/";
	$file = $path.$filename;
	if(file_exists($file)){
		unlink($file);
		$sql = "delete from files where filename='$filename';";
		if($conn->query($sql) == TRUE)
		{
			echo json_encode(array('type' => 'success'));
		}
		else
		{
		$rarray = array('type' => 'error',
					'message' => $conn->errno);
		echo json_encode($rarray);
		}

	}
	else
	{
		$rarray = array('type' => 'error',
					'message' => 'File does not exist');
		echo json_encode($rarray);
	}
}
else
{
	$rarray = array('type' => 'error',
					'message' => 'You dont have right to delete it' );
	echo json_encode($rarray);
}


}
else
	{
		$rarray = array('type' => 'error',
					'message' => 'File does not exist or you dont have rights on it');
		echo json_encode($rarray);
	}

}
else
{
	$rarray = array('type' => 'error',
					'message' => 'You dont have right to delete it' );
	echo json_encode($rarray);
}



}
else
header("Location: /studentportal/sessionerror.php");
?>