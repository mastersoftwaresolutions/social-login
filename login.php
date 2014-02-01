<?php
include 'base.php';
//$firstname=$_REQUEST['firstname'];
//$lastname=$_REQUEST['lastname'];
$email=$_REQUEST['email'];
$password=md5($_REQUEST['password']);
if(isset($_REQUEST['login'])){ //echo 'working';
    if(!empty($email) && !empty($password)){
        $chkemail=mysql_query("select * from users where email='$email' and password='$password'");
        $emailres=mysql_num_rows($chkemail);
        if(!empty($emailres)){
            echo "Login successfull";
	    session_start();
	    $_SESSION['email'] = $email;
	   header('location:coupon-list.php');
        }else {
            
            echo "Wrong username or password";
        }
    } else {
        
        echo "Please fill all required fields";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
   <!--validations
<script type="text/javascript" src="{{ asset('bundles/acmefrontend/js/jquery.validationEngine-en.js') }}"></script>  
<script type="text/javascript" src="{{ asset('bundles/acmefrontend/js/jquery.validationEngine.js') }}"></script>  

<link media="all" type="text/css" href="{{asset('bundles/acmefrontend/css/validationEngine.jquery.css')  }}" rel="stylesheet">-->

   <!--validations-->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>  
<script type="text/javascript" src="js/jquery.validationEngine-en.js"></script>  
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>  
<link media="all" type="text/css" href="css/bootstrap.css" rel="stylesheet">
<link media="all" type="text/css" href="css/docs.css" rel="stylesheet">
<link media="all" type="text/css" href="css/bootstrap-theme.css" rel="stylesheet">
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>  
<link media="all" type="text/css" href="css/validationEngine.jquery.css" rel="stylesheet">
    <script>
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#login_form").validationEngine();
			
		});
		
			
</script>
   </head>
   
<body>
   <div class="container"> 
     <div class="page-log">
      <a href="coupon-list.php"><img src="images/coupons.png" alt="coupons"></a>
              <h3><center>Login</center></h3>     
          <form id="login_form"  action="" method="post">
                  
         <div class="form-group">
            <input type="email" id="text" name="email" placeholder="Email Address" class="form-control validate[required,custom[email]] text-input">
          </div>
          
         <div class="form-group">
           <input type="password" id="password" name="password" placeholder="Password" class="form-control txtbox validate[required]">
         </div>
               
         
         <div class="form-group">
          <div class="col-sm-10">
            <button class="btn btn-primary" name="login" type="submit">Login</button>
           </div>
         </div>
         
        </form>
          
     </div>
    </div>
  
  
  </body>
  </html>
