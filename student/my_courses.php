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

$sql = "select SC.course_id,C.unique_id,f.name fname,C.name cname,C.slot,C.class_no from student_course SC JOIN course C ON SC.course_unique_id = C.unique_id JOIN faculty F ON C.faculty_id = F.id where student_regno = '$uid' ORDER BY SC.course_id;";
$result = $conn->query($sql);
?> 


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student - My courses</title>

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
                        Student
                    </a>
                </li>
                <li>
                    <a href="./profile.php">Profile</a>
                </li>
                <li>
                    <a href="./course_res.php">Course Registeration</a>
                </li>
                <li>
                    <a class="active" href="#">My Courses</a>
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
            	
            <h1>My courses</h1><br>

              <?php
              if ($result->num_rows > 0)
              {
               ?>
                 <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Name</th>
                            <th>Faculty Name</th>
                            <th>Slot</th>
                            <th colspan="2">Class No</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php

              while($row = $result->fetch_assoc())
              {

                   echo <<<EOD
                  <tr>
                  <td>{$row['course_id']}</td>
                  <td>{$row['cname']}</td>
                  <td>{$row['fname']}</td>
                  <td>{$row['slot']}</td>
                  <td>{$row['class_no']}</td>
                  <td>
                  <form action="../files.php" method="post" class="files">
                  <input type="hidden" name="unique_id" value="{$row['unique_id']}">
                  <button class="btn btn-primary btn-block">FILES</button>
                  </form>
                  </td>

                 
                  
                  </tr>
EOD;

  }

            ?>

                    </tbody>
                </table>
            <?php 
          }
          else
            echo '<h3 id="amessage" class="text-center">No courses have been registered yet</h3>';
          ?>

          <div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modelTitle">Files</h4>
      </div>
      <div class="modal-body" id="fileModelBody">

      <table class="table table-striped hidden" id="filestable">
    <thead>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="filestbody">
      <tr class="hidden" id="dummyRow">
        <td></td>
        <td><p></p></td>
        <td style="width:75px;min-width:75px">
        <a href="#" class="btn btn-primary">Download</a>
        </td>
      </tr>
    </tbody>
  </table>

  <h4 id="NoFiles" class="text-center">No files has been uploaded</h4>
  <br>


        




          
  
      </div>
      

  </div>
</div>




            </div>


    </div>
        
 </div>


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
 	
 	$('body').on("submit","form",function(event){






 event.preventDefault();
 $form = $(this);

if($form.hasClass('files')){
	 $("#filestable").addClass('hidden');
  $("#NoFiles").removeClass('hidden');
  var tr=$('#dummyRow').clone();
  $('#filestbody').html(tr);
 $('#unique_id').val($form.find('input').val());
 $("#myModal").modal('show');

 $.ajax({
                type: 'post',
                url: $form.attr('action'),
                data: $form.serialize(),
                success: function(response) {


                  ob = JSON.parse(response);
                  if(ob.type == 'success'){
                  $("#filestable").removeClass('hidden');
                  $("#NoFiles").addClass('hidden');
                  $.each(ob.message,function(index,value){



                    var tr=$('#dummyRow').clone();
                    tr.removeClass('hidden');
                    tr.find('td').eq(0).text(value.rname);
                    tr.find('td').eq(1).find('p').text(value.fdesc);
                    tr.find('td').eq(2).find('a').attr('href','../download.php?fname='+value.filename);
                    $('#filestbody').append(tr);

                  });
                }
                else
                {
                  $("#NoFiles").text(ob.message);
                }
                  
                  
                  

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