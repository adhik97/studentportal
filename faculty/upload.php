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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$unique_id=isset($_POST['unique_id'])?$_POST['unique_id']:null;



$sql = "select faculty_id from course where unique_id = '$unique_id';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if($row['faculty_id'] == $uid){


$rname = $_FILES['file']['name'];
$ext = pathinfo($rname, PATHINFO_EXTENSION);

	$fdesc = $_POST['fdesc'];
	$file = uniqid('',TRUE).'.'.$ext;
 
  $file_loc = $_FILES['file']['tmp_name'];
 $file_size = $_FILES['file']['size'];
 $file_type = $_FILES['file']['type'];
 $folder="../uploads/";

if(strlen($fdesc <= 500)){

			move_uploaded_file($file_loc,$folder.$file);
			 if(!$_FILES['file']['error']){

					
					 $sql="INSERT INTO files(filename,rname,fdesc,unique_id) VALUES('$file','$rname','$fdesc','$unique_id');";
					 
					if($conn->query($sql)){
						 $rarray = array('type' => 'success',
									 'message' =>  array('rname' => $rname,
									 					  'filename' => $file,
									 					  'fdesc' => $fdesc)
									  );

						echo json_encode($rarray);
					}
					else{
						

						 $rarray = array('type' => 'error',
									 'message' => $conn->errno );

						 echo json_encode($rarray);
					}
			}
			else {

				 $rarray = array('type' => 'error',
									 'message' => $_FILES['fileToUpload']['error'] );

			  	echo json_encode($rarray);


			}
		}
		else
		{
			 $rarray = array('type' => 'error',
						 'message' => 'File description cannot exceed 500 characters' );

  				echo json_encode($rarray);

		}
    }
    else
    {

    $rarray = array('type' => 'error',
						 'message' => 'You dont have required rights to upload this file' );

  	echo json_encode($rarray);

    }
  }
  else
  {
  	$rarray = array('type' => 'error',
						 'message' => 'Dont try to manipulate the form data' );

  	echo json_encode($rarray);
  }
$conn->close();
}

else
header("Location: /studentportal/sessionerror.php");
?>

