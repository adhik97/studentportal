<?php

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
    echo "<strong>Error: </strong>". $conn->error;
}

$conn->close();



?>



