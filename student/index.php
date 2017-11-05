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
    if($user != 'student')
        header("Location: ../usererror.php");

      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "test";


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);


      $sql = " select * from messages where sent_by='ADMIN' AND (recieve='ALL' OR recieve='STU') ORDER BY time_issued DESC;";

      $result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student - Home</title>

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
                    <a href="#">
                        Student
                    </a>
                </li>
                <li>
                    <a  href="./profile.php">Profile</a>
                </li>
                <li>
                    <a href="./course_res.php">Course Registeration</a>
                </li>
                <li>
                    <a href="./my_courses.php">My Courses</a>
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
        
                <h1>Home</h1><br>

                <h3>Announcements</h3>
                <br>
                <div class="panel-group">

                <?php 
  if($result->num_rows > 0){

     while($row = $result->fetch_assoc())
    {

    echo <<<EOD
     <div class="panelPart panel panel-default">
    <div class="panel-body"><p>{$row['messageData']}</p></div>
    <div class="panel-footer text-right"> 
  Posted : {$row['time_issued']}
  </div>
  </div>
EOD;

  }
}
  ?>


                </div>
                
           
        


              


    </div>
        
 </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Menu Toggle Script -->
    <script>
    $(document).ready(function(){
   $("#edit").click(function(){
    $("#viewprofile").toggle(200,function(){
    $("#editprofile").toggle(200);
    });
   });
});
    </script>

</body>

</html>
<?php
}
else
header("Location: /studentportal/sessionerror.php");
?>
