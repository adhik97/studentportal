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

      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "test";


$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error)
    die("Connection failed: " . $conn->connect_error);


      $sql = "select * from messages where sent_by='ADMIN' ORDER BY time_issued DESC;";

      $result = $conn->query($sql);
        




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
                
    <form action="../messages_submit.php" method="post">
    <div class="form-group">
   <label for="sel1">To:</label>
  <select class="form-control" id="sel1" name="recv" required>
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
    <input type="reset" class="btn btn-default" value="Reset">
  </form>
  
  <br>
  <br>
  <div class="panel-group" id="annPanel">

    
    <div class="panelPart panel panel-default hidden">
    <div class="panel-body"><p></p></div>
    <div class="panel-footer text-right"> 
    <div class="row">
    <div class="col-sm-4">To :</div>
  <div class="col-sm-4">Posted :</div>
  <div class="col-sm-4">
  <form action="../deletemessages.php" class="delete" method="post"><input type="hidden" value="" name="id"><button class="btn btn-xs btn-danger">Delete</button></form>
  </div>
  </div>
  </div>
  </div>

  <?php 
  if($result->num_rows > 0){

     while($row = $result->fetch_assoc())
    {

    echo <<<EOD
     <div class="panelPart panel panel-default">
    <div class="panel-body"><p>{$row['messageData']}</p></div>
    <div class="panel-footer text-right"> 
    <div class="row">
    <div class="col-sm-4">To : {$row['recieve']}</div>
  <div class="col-sm-4">Posted : {$row['time_issued']}</div>
  <div class="col-sm-4">
  <form action="../deletemessages.php" class="delete" method="post"><input type="hidden" value="{$row['id']}" name="id"><button class="btn btn-xs btn-danger">Delete</button></form>
  </div>
  </div>
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

        $('body').on('submit','form',function(event){
         event.preventDefault();
            $form = $(this);

            if ($(this).hasClass('delete'))
                {

                    

                $.ajax({
                type: 'post',
                url: $form.attr('action'),
                data: $form.serialize(),
                success: function(response) {

                  ob = JSON.parse(response);
                  if(ob.type == 'success'){

                   $form.closest('div.panelPart').remove();



                  }
                  else
                  {
                    alert(ob.message);
                  }

                }
                });

                }
                else{ 

                

                $.ajax({
                type: 'post',
                url: $form.attr('action'),
                data: $form.serialize(),
                success: function(response) {

                  

                    ob = JSON.parse(response);
                
               
                    if(ob.type == 'success'){
                      var dummy = $('div.panelPart').eq(0).clone();
                      dummy.find('p').html(ob.message.messageData);
                      dummy.find('div').eq(3).text('To : '+ob.message.recieve);
                      dummy.find('div').eq(4).text('Posted : '+ob.message.time_issued);
                      dummy.find('input').val(ob.message.id);
                      dummy.removeClass('hidden');
                      
                      $('#annPanel').append(dummy);
                      $form.find('input[type=reset]').click();




                    }
                    else
                      alert('Error : '+ob.message);
                    }
                });


                }

        });

      });

    </script>

</body>

</html>

<?php
$conn->close();
}
else
header("Location: ../sessionerror.php");
?>
