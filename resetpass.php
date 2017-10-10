<?php 

session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time();

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
              	<strong><h3 align="center">Password reset</h3></strong>
              <br>
<?php 

 if(isset($_SESSION['uid']))
 {
 	$form = '              
        <form method="post" action="./resetpass_submit.php">
        <p style="font-size:12px;">As this is your first time, please change your password</p>
          
        <div class="form-group">
          <input type="password" class="form-control" name="cpass" id="cpass" placeholder="Enter current password" title="Minumum 4 Digits Required" pattern=".{4,15}" required="required">
      </div>
      <div class="form-group">
          <input type="password" class="form-control" name="pass" id="pass" placeholder="Enter new password" title="Minumum 4 Digits Required" pattern=".{4,15}" required="required">
      </div>
        <div class="form-group">
          <input type="password" class="form-control" name="ccpass" id="ccpass" placeholder="Confirm new password" title="Minumum 4 Digits Required" pattern=".{4,15}" required="required">
      </div>
      <button type="submit" class="btn btn-primary form-control" id="chgtext">Change password</button>
        </form> ';
 	echo $form;
 }
 else
 	echo '<h4>Session expired, Please login before viewing this page </h4';
 ?>
        <div style="display:none;" id="messageBox">
      </div>
    </div>
  </div>
  
  </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript">
  	
  	 $(function () {
$('form').on("submit",function(event){
   event.preventDefault();
   $form=$(this);

   if($('#pass').val() == $('#ccpass').val()){

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
            
            

            }
          });
    }
    else {
    	 $('#messageBox').append('<div class="alert alert-info alert-dismissable"><a class="close" data-dismiss="alert">×</a><span>New password and Confirm password doesn\'t match!</span></div>');
              $('#messageBox').fadeIn(200);
              setTimeout(function(){
                $('#messageBox').find('a').eq(0).click();
              },10000);
    }

});


});
  </script>
  </body>
  </html>