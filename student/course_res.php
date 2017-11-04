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

// C JOIN faculty F ON c.faculty_id = F.id

$sql = "select course.id,course.unique_id,course.name,course.slot,course.class_no,faculty.name fname,course.faculty_id from course JOIN faculty ON course.faculty_id = faculty.id where course.unique_id not in (select distinct student_course.course_unique_id from student_course where student_regno='$uid');";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Student - Course Registration</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <link href="../css/simple-sidebar.css" rel="stylesheet">
    <style>
    .cont {
        background-color: #424242;
        border-radius: 3px 0px 0px 10px;
        padding: 10px;
        color: white;
    }

    .val {
        background-color: #bdbdbd;
        border-radius: 0px 3px 10px 0px;
        padding: 10px;
        min-height: 40px;
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
                    <a class="active" href="#">Course Registeration</a>
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
            <div class="container-fluid"></div>
            <h1>Course Registration</h1>
            <br>
            <?php 
       $hh='';
if ($result->num_rows <= 0)
 $hh='hidden'; 
echo '<div class="table-responsive '.$hh.'" id="atable">'; ?>
        <input class="form-control" id="myInput" type="text" placeholder="Search..">
        <br>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Course ID</th>
                            <th>Name</th>
                            <th>Faculty ID</th>
                            <th>Faculty Name</th>
                            <th>Slot</th>
                            <th colspan="2">Class No</th>
                        </tr>
                    </thead>
                    <tbody id="acourses">

                        <?php


    while($row = $result->fetch_assoc())
    {

    echo <<<EOD
    <tr>
    <td>{$row['id']}</td>
    <td>{$row['name']}</td>
    <td>{$row['faculty_id']}</td>
    <td>{$row['fname']}</td>
    <td>{$row['slot']}</td>
    <td>{$row['class_no']}</td>
    <td>
    <form action="./register.php" method="post">
    <input type="hidden" name="unique_id" value="{$row['unique_id']}">
    <button class="btn btn-primary btn-block">Register</button>
    </form>
    </td>

   
    </td>
    </tr>
EOD;

  }

      ?>
                    </tbody>
                </table>
            </div>
            
        <?php 
$hh='';
if ($result->num_rows > 0)
 $hh='hidden'; 
echo '<h3 id="amessage" class="text-center '.$hh.'">No courses have been offered yet/All courses have been registered</h3>';
?>


            <br>
            <br>
            <h2> Registered courses </h2>
            <?php 
$sql = "select course.id,course.unique_id,course.name,course.slot,course.class_no,faculty.name fname,course.faculty_id from course JOIN student_course ON course.unique_id = student_course.course_unique_id JOIN faculty ON course.faculty_id = faculty.id where student_course.student_regno = '$uid';";
$result = $conn->query($sql);

 $hh='';
if ($result->num_rows <= 0)
 $hh='hidden'; 
echo '<div class="table-responsive '.$hh.'" id="rtable">';
?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Name</th>
                        <th>Faculty ID</th>
                        <th>Faculty Name</th>
                        <th>Slot</th>
                        <th colspan="2">Class No</th>
                    </tr>
                </thead>
                <tbody id="rcourses">
                    <?php


    while($row = $result->fetch_assoc())
    {

    echo <<<EOD
    <tr>
    <td>{$row['id']}</td>
    <td>{$row['name']}</td>
    <td>{$row['faculty_id']}</td>
    <td>{$row['fname']}</td>
    <td>{$row['slot']}</td>
    <td>{$row['class_no']}</td>
    <td>
    <form action="./delete_course.php" class="registered" method="post">
    <input type="hidden" name="unique_id" value="{$row['unique_id']}">
    <button class="btn btn-danger btn-block">Delete</button>
    </form>
    </td>

   
    </td>
    </tr>
EOD;

  }

      ?>
                </tbody>
            </table>
        </div>
        <?php 
$hh='';
if ($result->num_rows > 0)
 $hh='hidden'; 
echo '<h3 id="rmessage" class="text-center '.$hh.'">No courses have been registered yet</h3>';
?>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="text-align:center">
                        <div id="loadingimage"><img src="../images/loading.gif" style="max-height:50px">
                            <br>
                        </div>
                        <h4 id="content">Registering</h4>
                    </div>
                    <div id="modalfooter" class="modal-footer hidden">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Okay</button>
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
    $(document).ready(function() {

         $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#acourses tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

        console.log('hello12');

        $("#edit").click(function() {
            $("#viewprofile").toggle(200, function() {
                $("#editprofile").toggle(200);
            });
        });

        $('table').on("submit", "form", function(event) {
            event.preventDefault();
            $form = $(this);

            if ($($form).hasClass('registered'))
                $("#content").html('Deleting');


            $("#myModal").modal('show');

            $.ajax({
                type: 'post',
                url: $form.attr('action'),
                data: $form.serialize(),
                success: function(response) {

                    JSONobject = JSON.parse(response);

                    $("#loadingimage").addClass('hidden');
                    $("#content").html(JSONobject.message);
                    $("#modalfooter").removeClass('hidden');

                    if (JSONobject.type == 'success') {

                        if ($form.hasClass('registered')) {
                             if ($("#atable").hasClass('hidden')) {
                                $("#atable").removeClass('hidden');
                                $('#amessage').addClass('hidden');
                            }
                            var tr = $form.closest("tr").remove().clone();
                            tr.find("button")
                                .removeClass('btn-danger')
                                .text('Register')
                                .addClass('btn-primary');
                            tr.find("form")
                                .attr('action', 'register.php')
                                .removeClass('registered');
                            $('#acourses').append(tr);
                            if ($("#rtable").find('tbody').find('tr').length == 0) {
                                $("#rmessage").removeClass('hidden');
                                $('#rtable').addClass('hidden');
                            }

                        } else {
                            if ($("#rtable").hasClass('hidden')) {
                                $("#rtable").removeClass('hidden');
                                $('#rmessage').addClass('hidden');
                            }
                            var tr = $form.closest("tr").remove().clone();
                            tr.find("button")
                                .removeClass('btn-primary')
                                .text('Delete')
                                .addClass('btn-danger');
                            tr.find("form")
                                .attr('action', 'delete_course.php')
                                .addClass('registered');
                            $('#rcourses').append(tr);
                            if ($("#atable").find('tbody').find('tr').length == 0) {
                                $("#amessage").removeClass('hidden');
                                $('#atable').addClass('hidden');
                            }

                        }
                    }




                }


            });

        });



    });
    </script>
</body>

</html>
<?php

$conn->close();
}
else
header("Location: /studentportal/sessionerror.php");
?>