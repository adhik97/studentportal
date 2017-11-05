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

$regno = !empty($_POST["regno"]) ? strtoupper($_POST["regno"]) : null;
$dpass = !empty($_POST["defpass"]) ? $_POST["defpass"] : null;
$name = !empty($_POST["name"]) ? $_POST["name"] : null;
$dob = !empty($_POST["dob"]) ? date("Y-m-d", strtotime($_POST["dob"])) : null;
$address = !empty($_POST["address"]) ? $_POST["address"] : null;
$phno = !empty($_POST["phno"]) ? $_POST["phno"] : 'null';
$email = !empty($_POST["email"]) ? $_POST["email"] : null;



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$defpass = hash('sha512', $dpass);
// Check connection
$sql = "INSERT INTO student values ('$regno','$defpass','$defpass','$name', ". ($dob==NULL ? "NULL" : "'$dob'") .",'$address',$phno,'$email');";
if ($conn->query($sql) === TRUE) {
    echo "<strong>Success: </strong>". $regno ." - " . $name ." was added successfully";
} else {
    echo "<strong>Error: </strong> This register number already taken";
}

$conn->close();

}
else
header("Location: ../sessionerror.php");




?>