<?php 

session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();
if(isset($_SESSION['uid'])){
    $user = $_SESSION['user'];

  
}
else
header("Location: /studentportal/sessionerror.php");
?>

<!DOCTYPE html>
<html>
    <title>Session expired</title>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
   
    </head>

    <style>
    body {font-family:Georgia}

  
    </style>

    <body style="background-color:grey">
        <div class="container">
          <div class="col-lg-4"></div>
          <div class="col-lg-4">
            <div class="jumbotron" style="margin-top:150px">
              	<strong><h3 align="center">User access error</h3></strong>
              <br>
              <p><?php echo "You are logged in as <strong>{$user}</strong>. You don't have right to access this"; ?></p> 

        
      </div>
    </div>
  </div>
  
  </div>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript"></script>
  </body>
  </html>