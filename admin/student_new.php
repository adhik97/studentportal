<?php


$regno = !empty($_POST["regno"]) ? $_POST["regno"] : null;
$defpass = !empty($_POST["defpass"]) ? $_POST["defpass"] : null;
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

// Check connection
$sql = "INSERT INTO student values ('$regno','$defpass','$defpass','$name', ". ($dob==NULL ? "NULL" : "'$dob'") .",'$address',$phno,'$email');";
if ($conn->query($sql) === TRUE) {
    echo "<strong>Success: </strong>". $regno ." - " . $name ." was added successfully";
} else {
    echo "<strong>Error: </strong>". $conn->error;
}

$conn->close();




?>