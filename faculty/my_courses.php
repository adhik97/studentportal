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

$sql = "select id,unique_id,name,slot,class_no from course where faculty_id= '$uid';";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Faculty - My courses</title>

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
                    <a href="./profile.php">Profile</a>
                </li>
               
                <li>
                    <a class="active" href="./my_courses.php">My Courses</a>
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
                  <td>{$row['id']}</td>
                  <td>{$row['name']}</td>
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
            echo '<h3 id="amessage" class="text-center">No courses have been alloted to you yet</h3>';
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
        <td style="width:150px;min-width:150px">
        <div class="btn-group">
        
        <form action="../delete.php" method="post" class="delete">
    <input type="hidden" value="" name="fname">
        <div class="btn-group">
        <a href="#" class="btn btn-primary">View</a>
      <button  class="btn btn-danger">Delete</button>
        </div>
        </form>

        </td>
      </tr>
    </tbody>
  </table>

  <h4 id="NoFiles" class="text-center">No files has been uploaded</h4>
  <br>


        




          <form class="form-horizontal" action="./upload.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label class="control-label col-sm-2" for="fdesc">Description:</label>
      <div class="col-sm-10">
        <textarea class="form-control" rows="3" name="fdesc" id="fdesc" placeholder="Maximum of 500 characters" maxlength="500"></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="file">File:</label>
      <div class="col-sm-10">          
        <input type="file" class="form-control" id="file" name="file" required>
      </div>
    </div>
    <input type="hidden" name="unique_id" id="unique_id">
   
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Upload</button>
      </div>
    </div>
    <input type="reset" class="hidden">
  </form>
  <div class="progress hidden" id="prograssBar">
  <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="70"
  aria-valuemin="0" aria-valuemax="100" style="width:0%">
    <span>0% Complete</span>
  </div>
</div>
<div id="messageBox"><div>
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
                    tr.find('td').eq(2).find('form')
                                      .find('a').attr('href','../download.php?fname='+value.filename);
                    tr.find('input').val(value.filename);
                    $('#filestbody').append(tr);






                  });
                }
                else
                {
                  $("#NoFiles").text(ob.message);
                }
                  
                  
                  

                }

 })

}
else if($form.hasClass('delete')){

   $form.find('button').text('Deleting')
                      .prop('disabled', true);
  $('#myModal').find('button').eq(0).addClass('hidden');
   
   $.ajax({
                  type: 'post',
                  url: $form.attr('action'),
                  data: $form.serialize(),
                  success: function(response) {
                     $('#myModal').find('button').eq(0).removeClass('hidden');
                    ob = JSON.parse(response);
                    if(ob.type == 'success'){

                      $form.closest('tr').remove();
                      if($("#filestbody").find('tr').length == 1){
                          $("#filestable").addClass('hidden');
                          $("#NoFiles").removeClass('hidden');

                        }

                    }
                    else
                    {
                     $form.find('button').text('Delete')
                      .prop('disabled', false);
                      alert(ob.message);
                    }
                    

  }

  });
}
else{

   var bar = $('#prograssBar');
    var percent = $('#prograssBar').find('div').eq(0);
    bar.removeClass('hidden');
    $("#messageBox").html('');

 
    $('#myModal').find('button').eq(0).addClass('hidden');

var formData = new FormData(this);
   $.ajax({
                  xhr: function() {
        var xhr = new window.XMLHttpRequest();
        

        // Upload progress
        xhr.upload.addEventListener("progress", function(evt){
            if (evt.lengthComputable) {
                var percentComplete = (evt.loaded / evt.total*100).toFixed(2);
                //Do something with upload progress
                //percentComplete = percentComplete.'%';
                percent.width(percentComplete+'%');
                percent.find('span').html(percentComplete+"% Complete");
                
            }
       }, false);

       // Download progress
     

       return xhr;
    },
                type: 'post',
                url: $form.attr('action'),
                data: formData,
                success: function(response) {
                   $('#myModal').find('button').eq(0).removeClass('hidden');

                   console.log(response);
                   ob = JSON.parse(response);
                   
                   if(ob.type == 'success'){
                      $("#messageBox").html('File uploaded successfully');
                      $form.find('input[type=reset]').click();
                      bar.addClass('hidden');


                    if($("#filestbody").find('tr').length == 1){
                    $("#NoFiles").addClass('hidden');
                    $("#filestable").removeClass('hidden');
                    }

                    var tr=$('#dummyRow').clone();
                    tr.removeClass('hidden');
                    tr.find('td').eq(0).text(ob.message.rname);
                    tr.find('td').eq(1).find('p').text(ob.message.fdesc);
                    tr.find('td').eq(2).find('form')
                                      .find('a').attr('href','../download.php?fname='+ob.message.filename);
                    tr.find('input').val(ob.message.filename);
                    $('#filestbody').append(tr);


                  }
                  else
                  {
                    $('#messageBox').html('Error: '+ob.message);
                  }
                },
                cache: false,
                contentType: false,
                processData: false

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