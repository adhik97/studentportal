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
 

$course_id = !empty($_POST["course_id"]) ? $_POST["course_id"] : null;
$cname = !empty($_POST["cname"]) ? $_POST["cname"] : null;
$slot = !empty($_POST["slot"]) ? $_POST["slot"] : null;
$classno = !empty($_POST["classno"]) ? $_POST["classno"] : null;
$f_id = !empty($_POST["f_id"]) ? $_POST["f_id"] : null;


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
$sql = "INSERT INTO course (id,name,faculty_id,slot,class_no) VALUES ('$course_id','$cname','$f_id','$slot','$classno');";
$sql2 = "UPDATE class SET $slot='Yes' WHERE no='$classno';";
if ($conn->query($sql) === TRUE && $conn->query($sql2)===TRUE) {
    echo "<strong>Success: </strong>". $course_id ." - " . $cname ." under ".$f_id." in ".$slot." slot (".$classno.") was added successfully";
} else {
    echo "<strong>Error: </strong> This faculty already has a course on that slot";
}

$conn->close();

}
else
header("Location: ../sessionerror.php");




?>