<!DOCTYPE html>
<html lang="en" >
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(!empty($_POST["submit"])) 
     {
	$loginquery ="SELECT * FROM admin WHERE username='$username' && password='".md5($password)."'";
	$result=mysqli_query($db, $loginquery);
	$row=mysqli_fetch_array($result);
	
	                        if(is_array($row))
								{
                                    	$_SESSION["adm_id"] = $row['adm_id'];
										 header("refresh:1;url=dashboard.php");
	                            } 
							else
							    {
                                      	$message = "Invalid Username or Password!";
                                }
	 }
	
	
}

if(isset($_POST['submit1'] ))
{
     if(empty($_POST['cr_user']) ||
   	    empty($_POST['cr_email'])|| 
		empty($_POST['cr_pass']) ||  
		empty($_POST['cr_cpass']) ||
		empty($_POST['code']))
		{
			$message = "ALL fields must be fill";
		}
	else
	{
		
	
	$check_username= mysqli_query($db, "SELECT username FROM admin where username = '".$_POST['cr_user']."' ");
	
	$check_email = mysqli_query($db, "SELECT email FROM admin where email = '".$_POST['cr_email']."' ");
	
	  $check_code = mysqli_query($db, "SELECT adm_id FROM admin where code = '".$_POST['code']."' ");

	
	if($_POST['cr_pass'] != $_POST['cr_cpass']){
       	$message = "Password not match";
    }
	
    elseif (!filter_var($_POST['cr_email'], FILTER_VALIDATE_EMAIL)) // Validate email address
    {
       	$message = "Invalid email address please type a valid email!";
    }
	elseif(mysqli_num_rows($check_username) > 0)
     {
    	$message = 'username Already exists!';
     }
	elseif(mysqli_num_rows($check_email) > 0)
     {
    	$message = 'Email Already exists!';
     }
	 if(mysqli_num_rows($check_code) > 0)           // if code already exist 
             {
                   $message = "Unique Code Already Redeem!";
             }
	else{
       $result = mysqli_query($db,"SELECT id FROM admin_codes WHERE codes =  '".$_POST['code']."'");  //query to select the id of the valid code enter by user! 
					  
                     if(mysqli_num_rows($result) == 0)     //if code is not valid
						 {
                            // row not found, do stuff...
			                 $message = "invalid code!";
                         } 
                      
                      else                                 //if code is valid 
					     {
	
								$mql = "INSERT INTO admin (username,password,email,code) VALUES ('".$_POST['cr_user']."','".md5($_POST['cr_pass'])."','".$_POST['cr_email']."','".$_POST['code']."')";
								mysqli_query($db, $mql);
									$success = "Admin Added successfully!";
						 }
        }
	}

}
?>

<head>
  <meta charset="UTF-8">
  <title>Doof With Food - Admin</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

	<link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
      <link rel="stylesheet" href="css/login.css">

  
</head>

<body>

  
<div class="container-fluid">
 <div class="row customer__login">
	<div class="col-md-3"></div>
	<div class="col-md-6">
	<div class="form">
 
  
 <form class="register-form" action="index.php" method="post">
 <img src="images/doofwithfoodLogo.png" alt="" class="mb-3">
 <div class="input-group mb-3">
					   <input type="text" class="form-control venor__login__input"  placeholder="Username *" required="" name="cr_user">
					  
				   </div>
				   <div class="input-group mb-3">
					   <input type="text" class="form-control venor__login__input"  placeholder="Email Id *" required="" name="cr_email">
					  
				   </div>
 
				   <div class="input-group mb-3">
					   <input type="text" class="form-control venor__login__input"  placeholder="Password *" required="" name="cr_pass">
					  
				   </div>
				   <div class="input-group mb-3">
					   <input type="text" class="form-control venor__login__input"  placeholder="Confirm Password *" required="" name="cr_pass">
					  
				   </div>
				   <div class="input-group mb-3">
					   <input type="text" class="form-control venor__login__input"  placeholder="Unique Code *" required="" name="code">
					  
				   </div>

  <input type="submit"  name="submit1" value="Create an account" class="btn btn-success"/>
  <div class="Cannot__login__block">
				  <p class="message"> <span class="cannot__login">Already Registered?</span>  <span class="pass__register"><a href="#">Login</a></span></p>
			   </div>
   
 </form>

 <span style="color:red;"><?php echo $message; ?></span>
  <span style="color:green;"><?php echo $success; ?></span>
 <form class="login-form" action="index.php" method="post">
 <img src="images/doofwithfoodLogo.png" alt="" class="mb-3">
   <input type="text" placeholder="username" name="username"/>
   <input type="password" placeholder="password" name="password"/>
   <input type="submit"  name="submit" value="Login" class="btn btn-success"/>
   <div class="Cannot__login__block">
				  <p class="message"> <span class="cannot__login">Not Registered?</span>  <span class="pass__register"><a href="#">Create an acoount</a></span></p>
			   </div>
 </form>
 </div>
	</div>
	<div class="col-md-3"></div>
 </div>
  
  
</div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src='js/index.js'></script>
  

    



</body>

</html>
