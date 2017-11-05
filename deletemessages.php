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

    if($user == 'admin')
    	$uid = 'ADMIN';

 $id = !empty($_POST["id"]) ? $_POST["id"] : null;


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);

	$sql="select * from messages where id='$id';";
	
	$result=$conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if($row['sent_by'] == $uid){
			$sql = "delete from messages where id='$id';";
			if($conn->query($sql) === TRUE)
			{
				$rarray = array('type' => 'success');
				echo json_encode($rarray);
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
							'message' => 'You dont have rights to delete this');
				echo json_encode($rarray);
		}
	}
	else
	{
		$rarray = array('type' => 'error',
							'message' => 'Message not found');
				echo json_encode($rarray);
	}



$conn->close();
}
else
header("Location: ../sessionerror.php");



?>

