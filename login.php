<?php

session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}


$uname = isset($_POST['uname'])?$_POST['uname']:null;
$pword = isset($_POST['pword'])?$_POST['pword']:null;

if(strlen($pword) == 0 || strlen($uname) == 0)
echo '<h1 style="text-align:center;">Don\'t leave the field blank</h1';
else if(!(strlen($uname) == 5 || strlen($uname) == 10))
echo '<h1 style="text-align:center;">Enter a proper User ID</h1>';


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if(strlen($uname) == 10 ){
	$sql="select defpass,pass from student where regno='$uname';";
	$user="student";
}
else{
 $sql="select defpass,pass from faculty where id='$uname';";
 $user="faculty";
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {

	$pwordhash=hash('sha512',$pword);
	$row=$result->fetch_assoc();
	if($pwordhash == $row['pass']){

		$_SESSION['uid']=$uname;
		$_SESSION['user']=$user;
		$_SESSION['LAST_ACTIVITY'] = time();


		if($row['pass'] == $row['defpass'])
			echo 'passchange';
		else
		{
			
			echo 'success';

		}
	}
	else
		echo 'Wrong credentials';
}
else
{
echo "User does not exist";
}


$conn->close(); 

?>


