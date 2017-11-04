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
    if($user != 'student')
        header("Location: ../usererror.php");

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

$sql = "select id,slot from course where unique_id='$unique_id';";
$result = $conn->query($sql);
$row = $result->fetch_array();
$courseid = $row['id'];
$slot = $row['slot'];


$sql="select count(*) from student_course JOIN course ON student_course.course_unique_id = course.unique_id WHERE slot='$slot' AND student_regno='$uid';";
$result = $conn->query($sql);
$row = $result->fetch_array();

if($row[0]==0){


$sql = "select count(*) from student_course where course_unique_id='$unique_id';";

$result = $conn->query($sql);

$row = $result->fetch_array();
$registeredStudents =  $row[0];


$sql = "select max_strength from course where unique_id='$unique_id';";
$result = $conn->query($sql);
$row = $result->fetch_array();
$max_strength = $row[0];


if($registeredStudents < $max_strength){
	$sql = "insert into student_course(student_regno,course_unique_id,course_id) values ('$uid','$unique_id','$courseid');";

	if($conn->query($sql) == TRUE){

		$rarray = array('type' => 'success',
					  'message' => 'Successfully registered' );

		echo json_encode($rarray);
	}
	else
	{
		
		$rarray = array('type' => 'error',
					  'error_code' => $conn->errno,
					  'message' => 'Course already registered' );

		echo json_encode($rarray);

	}
}
else{
$rarray = array('type' => 'error',
				'message' => 'The class is full' );

		echo json_encode($rarray);

	}
}
else
	{
	$rarray = array('type' => 'error',
					'message' => 'Slot clash' );

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
