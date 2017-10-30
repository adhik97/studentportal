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

if(isset($_POST['unique_id'])){

$unique_id = $_POST['unique_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "delete from student_course where student_regno='$uid' AND course_unique_id = '$unique_id';";

	if($conn->query($sql) == TRUE){

		$rarray = array('type' => 'success',
						 'message' => 'Successfully deleted' );

			echo json_encode($rarray);
	}
	else
	{
		$rarray = array(  'type' => 'error',
						  'error_code' => $conn->errno,
						  'message' => 'DB Error' );

			echo json_encode($rarray);
	}
}
else
{
	$rarray = array('type' => 'error',
					'message' => 'Wrong usage' );

			echo json_encode($rarray);


}

}
else
header("Location: /studentportal/sessionerror.php");

?>
