<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
     $(function () {
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
            
            if(response.search("Success")>=0)
              $form.find('button[type="reset"]').click();

            }
          });
    
});

function ajaxOption(data,callback){
$.ajax({
    type:'post',
    url:'./get_option.php',
    data:data,
    success: function(response){
      //$('#messageBox').html(response);
      callback(response);
    },
    error: function(response){
      callback(response);
     
    }
  });

}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

$('#slot').on('change', function() {
  $('#classno').html(" <option disabled selected value> -- select a slot -- </option>");
  

    data='slot='+this.value;
    ajaxOption(data,function(response){

    if(isJson(response)){
      var arr=JSON.parse(response);
      $.each(arr, function( index, value ) {
      $('#classno').append("<option>"+value+"</option>");
});
    } 
     else
    {
 $('#messageBox').append('<div class="alert alert-info alert-dismissable"><a class="close" data-dismiss="alert">×</a><span>'+response+'</span></div>');
              $('#messageBox').fadeIn(200);
              setTimeout(function(){
                $('#messageBox').find('a').eq(0).click();
              },10000);
    } 

 });

});

$("#course_link,#resfresh_flist").click (function(){

  $('#f_id').html("<option disabled selected value> -- select a faculty -- </option>");
  data='f_id=true';
  ajaxOption(data,function(response){
    
     if(isJson(response)){
      var arr=JSON.parse(response);
      $.each(arr, function( index, value ) {
      $('#f_id').append("<option value="+value.id+">"+value.id +" - "+value.name+"</option>");
    });
    } 
     else
    {
 $('#messageBox').append('<div class="alert alert-info alert-dismissable"><a class="close" data-dismiss="alert">×</a><span>'+response+'</span></div>');
              $('#messageBox').fadeIn(200);
              setTimeout(function(){
                $('#messageBox').find('a').eq(0).click();
              },10000);
    } 
    });

});

});

  </script>
</head>
<body>



<div class="container">
<br>
  
  <div class="panel panel-default">
  <div class="panel-heading"> <ul class="nav nav-pills">
    <li><a data-toggle="pill" href="#student">New Student</a></li>
    <li><a data-toggle="pill" href="#faculty">New Faculty</a></li>
    <li><a data-toggle="pill" href="#course" id="course_link">New Course</a></li>
    <li><a data-toggle="pill" href="#class">New Class</a></li>
  </ul></div>
  
  <div class="panel-body">
   <div class="tab-content">

   <div class="tab-pane fade in active"><h4 class="text-center">Click on any above tab to add a new content</h4></div>

    <div id="student" class="tab-pane fade"><br>
     
      <form class="form-horizontal" action="./student_new.php">
  <div class="form-group">
      <label class="control-label col-sm-2" for="regno">Regno:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="regno" placeholder="Enter register number" name="regno" required>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="defpass">Default Password:</label>
      <div class="col-sm-6">
        <input type="password" class="form-control" id="defpass" placeholder="Enter default password" name="defpass" required>
      </div>
      <div class="col-sm-2">
      <button class="btn btn-info btn-block" onclick="getRandomInt('defpass')" type="button">Gen Password</button>
      </div>
       <div class="col-sm-2">
      <button class="btn btn-primary btn-block" onclick="toggler(this,'defpass')" type="button">Show</button>
      </div>
    </div>
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
      </div>
    </div>
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="dob">DOB:</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" id="dob"  name="dob">
      </div>
    </div>
  
    
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="address">Address:</label>
      <div class="col-sm-10">
        <textarea class="form-control" rows="3" id="address" name="address" placeholder="Enter address"></textarea>
      </div>
    </div>
    
      <div class="form-group">
      <label class="control-label col-sm-2" for="phno">Ph Number:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="phno" placeholder="Enter phone number" name="phno">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
      </div>
    </div>
    
      
   
   
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-success btn-block">Submit</button>
      </div>
       <div class="col-sm-2">
        <button type="reset" class="btn btn-default btn-block">Reset</button>
      </div>
      
    </div>
  </form>
    </div>
    <div id="faculty" class="tab-pane fade"><br>
  <form class="form-horizontal" method="post" action="./faculty_new.php">
  <div class="form-group">
      <label class="control-label col-sm-2" for="fid">Faculty ID:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="fid" placeholder="Enter faculty ID" name="fid" required>
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="defpassf">Default Password:</label>
      <div class="col-sm-6">
        <input type="password" class="form-control" id="defpassf" placeholder="Enter default password" name="defpassf" required>
      </div>
      <div class="col-sm-2">
      <button class="btn btn-info btn-block" onclick="getRandomInt('defpassf')" type="button">Gen Password</button>
      </div>
       <div class="col-sm-2">
      <button class="btn btn-primary btn-block" onclick="toggler(this,'defpassf')" type="button">Show</button>
      </div>
    </div>
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="fname">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="fname" placeholder="Enter name" name="fname" required>
      </div>
    </div>
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="fdob">DOB:</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" id="fdob"  name="fdob">
      </div>
    </div>
  
    
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="faddress">Address:</label>
      <div class="col-sm-10">
        <textarea class="form-control" rows="3" id="faddress" name="faddress" placeholder="Enter address"></textarea>
      </div>
    </div>
    
      <div class="form-group">
      <label class="control-label col-sm-2" for="fphno">Ph Number:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="fphno" placeholder="Enter phone number" name="fphno">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="femail">Email:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="femail" placeholder="Enter email" name="femail">
      </div>
    </div>

     <div class="form-group">
      <label class="control-label col-sm-2" for="position">Position:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="position" placeholder="Enter position" name="position">
      </div>
    </div>
    
      
   
   
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-success btn-block">Submit</button>
      </div>
       <div class="col-sm-2">
        <button type="reset" class="btn btn-default btn-block">Reset</button>
      </div>
      
    </div>
  </form>
      
    </div>
    <div id="course" class="tab-pane fade">
      <form class="form-horizontal" action="./course_new.php">
  <div class="form-group">
      <label class="control-label col-sm-2" for="course_id">Course ID:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="course_id"  style="text-transform:uppercase" placeholder="Enter course id" name="course_id" required>
      </div>
    </div>
    
    
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="cname">Course name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="cname" placeholder="Enter course name" name="cname" required>
      </div>
    </div>
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="slot">Slot:</label>
      <div class="col-sm-10">
        <select class="form-control" id="slot" required name="slot">
        <option disabled selected value> -- select a slot -- </option>
    <option>A</option>
    <option>B</option>
    <option>C</option>
    
  </select>
      </div>
    </div>
  
    
    
     <div class="form-group">
      <label class="control-label col-sm-2" for="classno">Class number:</label>
      <div class="col-sm-10">
        <select class="form-control" id="classno" name="classno" required>
    
  </select>
      </div>
    </div>
    
      <div class="form-group">
      <label class="control-label col-sm-2" for="f_id">Faculty Number:</label>
      <div class="col-sm-10">
        <select class="form-control" id="f_id" required name="f_id">
    
  </select>
      </div>
    </div>
    
  
      
   
   
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-success btn-block">Submit</button>
      </div>
       <div class="col-sm-2">
        <button type="reset" class="btn btn-default btn-block">Reset</button>
      </div>
      <div class="col-sm-4">
        <button id="resfresh_flist" type="button" class="btn btn-info btn-block">Referesh Faculty list</button>
      </div>
      
    </div>
  </form>
    </div>
    <div id="class" class="tab-pane fade">

     <form method="post" class="form-horizontal" action="./class_new.php">
  <div class="form-group">
      <label class="control-label col-sm-2" for="class_no">Class number:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="class_no" placeholder="Enter class number" name="class_no" required>
      </div>
    </div>
    
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-2">
        <button type="submit" class="btn btn-success btn-block">Submit</button>
      </div>
       <div class="col-sm-2">
        <button type="reset" class="btn btn-default btn-block">Reset</button>
      </div>
      
    </div>
  </form>
      
    </div>
  </div>

<div style="display:none;" id="messageBox">
   
  </div>

  </div>
</div> 
</div>



<script>
function toggler(e,id) {
        if( e.innerHTML == 'Show' ) {
            e.innerHTML = 'Hide'
            document.getElementById(id).type="text";
        } else {
            e.innerHTML = 'Show'
            document.getElementById(id).type="password";
        }
}

function getRandomInt(e) {
	
    c = Math.floor(Math.random() * (99999999 - 10000000 + 1)) + 10000000;
    document.getElementById(e).value=c;
    
}

</script>
</body>
</html>