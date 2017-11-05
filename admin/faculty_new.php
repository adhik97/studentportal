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



$fid = !empty($_POST["fid"]) ? $_POST["fid"] : null;
$dpassf = !empty($_POST["defpassf"]) ? $_POST["defpassf"] : null;
$fname = !empty($_POST["fname"]) ? $_POST["fname"] : null;
$fdob = !empty($_POST["fdob"]) ? date("Y-m-d", strtotime($_POST["fdob"])) : null;
$faddress = !empty($_POST["faddress"]) ? $_POST["faddress"] : null;
$fphno = !empty($_POST["fphno"]) ? $_POST["fphno"] : 'null';
$femail = !empty($_POST["femail"]) ? $_POST["femail"] : null;
$position = !empty($_POST["position"]) ? $_POST["position"] : null;
//echo $fphno;

//echo $_POST["fdob"] . " - " . $fdob;


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$defpassf = hash('sha512', $dpassf);

// Check connection
$sql = "INSERT INTO faculty values ('$fid','$defpassf','$defpassf','$fname', ". ($fdob==NULL ? "NULL" : "'$fdob'") .",'$faddress',$fphno,'$femail','$position');";
if ($conn->query($sql) === TRUE) {
    echo "<strong>Success: </strong>". $fid ." - " . $fname ." was added successfully";
} else {
    echo "<strong>Error: </strong> This faculty ID has been taken";
}

$conn->close();


}
else
header("Location: ../sessionerror.php");

?>