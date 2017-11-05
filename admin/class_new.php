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



$class_no = !empty($_POST["class_no"]) ? $_POST["class_no"] : null;





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
$sql = "INSERT INTO class (no) values ('$class_no');";
if ($conn->query($sql) === TRUE) {
    echo "<strong>Success: </strong>". $class_no ." was added successfully";
} else {
    echo "<strong>Error: </strong> This class already exists";
}

$conn->close();

}
else
header("Location: ../sessionerror.php");


?>



