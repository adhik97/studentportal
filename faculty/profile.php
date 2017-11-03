<?php 

session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";
if(isset($_SESSION['uid'])){
$uid=$_SESSION['uid'];

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



$sql = "select id,name,dob,address,phno,email,position from faculty where id= '$uid';";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
  }

  $conn->close();

}
else
header("Location: ../sessionerror.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Faculty - Profile</title>

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
                        Faculty
                    </a>
                </li>
                <li>
                    <a class="active" href="#">Profile</a>
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
        
                <h1>Profile</h1><br>
                
           
        <div id="viewprofile">
              <div class="row">
                <div class="col-sm-4 cont" ><strong>Reg No:</strong></div>
                <div class="col-sm-8 val" ><?php echo $row['id']; ?></div>
              </div><br>
              <div class="row">
                <div class="col-sm-4 cont" ><strong>Name:</strong></div>
                <div class="col-sm-8 val" ><?php echo $row['name']; ?></div>
              </div> <br>
              <div class="row">
                <div class="col-sm-4 cont" ><strong>DOB:</strong></div>
                <div class="col-sm-8 val" ><?php echo $row['dob']; ?></div>
              </div> <br>
              <div class="row">
                <div class="col-sm-4 cont" style="min-height:100px;"><strong>Address:</strong></div>
                <div class="col-sm-8 val" style="min-height:100px;"><?php echo $row['address']; ?></div>
              </div> <br>
              <div class="row">
                <div class="col-sm-4 cont" ><strong>Ph no:</strong></div>
                <div class="col-sm-8 val" ><?php echo $row['phno']; ?></div>
              </div><br>
              <div class="row">
                <div class="col-sm-4 cont" ><strong>Email:</strong></div>
                <div class="col-sm-8 val" ><?php echo $row['email']; ?></div>
              </div><br>
               <div class="row">
                <div class="col-sm-4 cont" ><strong>Position:</strong></div>
                <div class="col-sm-8 val" ><?php echo $row['position']; ?></div>
              </div>  
              <br>
            </div> 
<br>
<!--
<div id="editprofile" style="display:none;">
<form class="form-horizontal" action="./update_faculty.php">
  <div class="form-group">
      <label class="control-label col-sm-2" for="id">ID:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="id" value="<?php echo $row['id']; ?>" placeholder="Enter register number" name="id" required disabled>
      </div>
    </div>
    
   
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="name" value="<?php echo $row['name']; ?>" placeholder="Enter name" name="name" required>
      </div>
    </div>
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="dob">DOB:</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" id="dob" value="<?php echo $row['dob']; ?>" name="dob">
      </div>
    </div>
    
  
    
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="address">Address:</label>
      <div class="col-sm-10">
        <textarea class="form-control" rows="3" id="address" name="address" placeholder="Enter address"><?php echo $row['address']; ?></textarea>
      </div>
    </div>
    
      <div class="form-group">
      <label class="control-label col-sm-2" for="phno">Ph Number:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="phno" placeholder="Enter phone number" value="<?php echo $row['phno']; ?>" name="phno">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="email" placeholder="Enter email" value="<?php echo $row['email']; ?>" name="email">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="position">Position:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="position" placeholder="Enter email" value="<?php echo $row['position']; ?>" name="position">
      </div>
    </div>
    
      
   
   
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-success btn-block">Save</button>
      </div>
       <div class="col-sm-2">
        <button type="reset" class="btn btn-default btn-block">Reset</button>
      </div>
      
    </div>
  </form>
</div>
-->
             <h4> Click <a href="../resetpass.php" style="text-decoration: none;">here</a> if you wish to change the password</h4>
   
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
    /*$(document).ready(function(){
   $("#edit").click(function(){
    $("#viewprofile").toggle(200,function(){
    $("#editprofile").toggle(200);
    });
   });


$('form').on("submit",function(event){
   event.preventDefault();
   $form=$(this);
   

    $.ajax({
            type: 'post',
            url: $form.attr('action'),
            data: $form.serialize(),
            success: function (response) {

               $('#messageBox').append('<div class="alert alert-info alert-dismissable"><a class="close" data-dismiss="alert">×</a><span>'+response+'</span></div>');
              $('#messageBox').fadeIn(200);
              setTimeout(function(){
                $('#messageBox').find('a').eq(0).click();
              },10000);
              
              if(response.search('Profile updated')==0){

          

              setTimeout(function(){
                 $("#editprofile").toggle(200,function(){
                location.reload();
               });
              },1000);
            
           }

            }
          });
    
});
}); */
    </script>

</body>

</html>
