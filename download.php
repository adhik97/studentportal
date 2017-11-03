<?php

session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();

if(isset($_SESSION['uid'])){

$path = "./uploads/";
$file = $path.$_REQUEST['fname'];

ignore_user_abort(true);
session_write_close();

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    //header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    //header("Accept-Ranges: bytes");
	
		 set_time_limit(0);
		$filep = @fopen($file,"rb");
		while(!feof($filep))
		{
			print(@fread($filep, 1024*8));
			ob_flush();
			flush();
		}
    
    
}
else
{
	$rarray = array('type' => 'error',
					'message' => 'File does not exist' );
	echo json_encode($rarray);
}



}
else
header("Location: /studentportal/sessionerror.php");
?>

