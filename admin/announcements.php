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




?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

  <title>Admin - Announcements</title>

    <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Custom styles for this template -->

    <link href="../css/simple-sidebar.css" rel="stylesheet">
    <style>
  .cont {
  background-color:#424242;
  border-radius:3px 0px 0px 10px;
  padding:10px;
  color:white;
  }
  
  .val {
  background-color:#bdbdbd; 
  border-radius:0px 3px 10px 0px;
  padding:10px;
  min-height:40px;
  }
  </style>

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="./">
                        Admin
                    </a>
                </li>
               
              
                <li>
                    <a href="#" class="active">Announcements</a>
                </li>
                 <li>
                    <a href="/studentportal">Log out</a>
                </li>

                <!--<li>
                    <a href="#">Events</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li> -->
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
        
                <h1>Announcements</h1><br>
                
    <form action="../messages.php">
    <div class="form-group">
   <label for="sel1">To:</label>
  <select class="form-control" id="sel1" required>
    <option value="ALL">ALL</option>
    <option value="STU">STUDENTS</option>
    <option value="FAC">FACULTIES</option>
  </select>
      
    </div>
    <div class="form-group">
      <label for="ann">Message:</label>
    <textarea class="form-control" name="ann" maxlength="65535" id="ann" rows="6" required></textarea>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
        


              


    </div>
        
 </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Menu Toggle Script -->
    <script></script>

</body>

</html><?php

}
else
header("Location: ../sessionerror.php");
?>
