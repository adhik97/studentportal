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

      
$slot = isset($_POST["slot"]) ? $_POST["slot"] : null;
$fid = isset($_POST["f_id"]) ? $_POST["f_id"] : null;


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if($slot) {
$sql = "select no from class where ".$slot."='No';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {

	
    // output data of each row
    $rows = array();
   while($row = $result->fetch_assoc()) {
       $rows[] = $row[array_keys($row)[0]];
    } 
    //print_r($rows);

    echo json_encode($rows);

} else {

    echo "No free class found, choose a differect slot";
	}
}
else if($fid)
{
	$sql = "select id,name from faculty;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {

  $rows = array();
   while($row = $result->fetch_assoc()) {
       $rows[] = $row;
    } 
    //print_r($rows);

    echo json_encode($rows);

} else {

    echo "No faculty data found";
	}


}
else
{
  $sql = "select no from slot;";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {

    $rows = array();
    while($row = $result->fetch_assoc()) {
       $rows[] = $row[array_keys($row)[0]];
    }

    echo json_encode($rows); 
}else {

    echo "No slots are there";
  }
}



$conn->close(); 
}
else
header("Location: ../sessionerror.php");





?>