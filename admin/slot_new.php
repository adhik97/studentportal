<?php

$slot_no = !empty($_POST["slot_no"]) ? $_POST["slot_no"] : null;
$timing = !empty($_POST["timing"]) ? $_POST["timing"] : null;



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
$sql = "INSERT INTO slot (no,timing) values ('$slot_no','$timing');";
if ($conn->query($sql) === TRUE) {
	
	$sql2 = "ALTER TABLE class ADD ".$slot_no." VARCHAR(2) NOT NULL DEFAULT 'No';";
	
	if ($conn->query($sql2) === TRUE){
    echo "<strong>Success: </strong>". $slot_no ." was added successfully";
	}
	else {
    echo "<strong>Error: </strong>". $conn->error;
	}

}
else {
    echo "<strong>Error: </strong>". $conn->error;
}

$conn->close();



?>

