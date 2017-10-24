<?php 
session_start();
session_unset();      
session_destroy();

?>
<html>
    <title>Academic Portal</title>
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
              	<strong><h3 align="center">Acadamic Portal</h3></strong>
              <br>
        <form method="post" action="./login.php">
          <div class="form-group"><a href="#" data-toggle="tooltip" title="User ID should be of either 5 or 10 characters">
            <input type="text" class="form-control" name="uname" id="username" placeholder="Enter ID" pattern="([A-Z]{3}[0-9]{7}|[0-9]{5})"  style="text-transform:uppercase" maxlength="10" required="required"></a>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="pword" id="pwrod" placeholder="Enter Password" title="Minumum 4 Digits Required" pattern=".{4,15}" required="required">
      </div>
      <button type="submit" class="btn btn-primary form-control" id="chgtext">Login</button>
        </form>
        <div style="display:none;" id="messageBox">
      </div>
    </div>
  </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script>
    $(function(){
    
    $("#username").keypress(function(){
      //console.log("hello");
        var val=$(this).val();
        if(val.length==4){
          //console.log("check");
          $("#chgtext").html("Login as Faculty");
        }
        else if(val.length == 9){
            $("#chgtext").html("Login as Student");
        }
        else
          $("#chgtext").html("Login");
        
          

    });


    $('button[type="submit"').click(function(){
      
      

      l = $("#username").val().length;r="";
      if( !(l == 5 || l == 10))
        r=r+"Enter a proper User ID";
      if($("#pwrod").val().length < 4)
        r=r+"\nPassword should be of minimum 4 characters";

      if(r.length>0){
         $('#messageBox').append('<div class="alert alert-danger alert-dismissable"><a class="close" data-dismiss="alert">×</a><span>'+r+'</span></div>');
              $('#messageBox').fadeIn(200);
              setTimeout(function(){
                $('#messageBox').find('a').eq(0).click();
              },10000);
      }
         }); 

      $('form').on("submit",function(event){
   event.preventDefault();
   $form=$(this);

    $.ajax({
            type: 'post',
            url: $form.attr('action'),
            data: $form.serialize(),
            success: function (response) {


              if(response.search('success')==0){
                if( $("#username").val().length ==5)
                window.location = './faculty/';
                else
                window.location = './student/';
              }

              else if(response.search('passchange')==0){
                
                window.location = 'resetpass.php';
              }

              else{
              
               $('#messageBox').append('<div class="alert alert-danger alert-dismissable"><a class="close" data-dismiss="alert">×</a><span>'+response+'</span></div>');
              $('#messageBox').fadeIn(200);
              setTimeout(function(){
                $('#messageBox').find('a').eq(0).click();
              },10000);
            
            
            }
            }
          }); 
      });
});
    </script>
    </body>
</html>
