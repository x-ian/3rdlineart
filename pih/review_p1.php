<?php 
 session_start();
 global $now,$expire,$user_id,$fullname;
 if (isset($_SESSION['identification'])){

	/* global  $fullname;*/
       $fname= $_SESSION['fname'];
       $lname= $_SESSION['lname'];
       $fullname =$fname . " " .$lname;
    
       /*$fname= $_SESSION['fname'];
       $lname= $_SESSION['lname'];*/
       $user_id=$_SESSION['identification'];
     
       /*$fullname =$_SESSION['name'];*/
       $phone= $_SESSION['phone'];
       $email= $_SESSION['email'];
      
     
	   $now = time(); 
	   $expire= $_SESSION['expire'];}
	   
	   ?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Application Form</title>
    
   <?php 
    
include ('../includes/head.php');
    
    ?>
    
    <style>
    input[type="text"] {
    height: 35px; 
    }
   /* input[type="submit"] {
    width: 200px;
        
    }
    */
    </style>
</head>
<body>
<?php
    include ('../includes/nav_main.php');
    include ('../includes/nav_sub.php');
    
    ?>
    
<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	 <?Php
if (isset($_SESSION['identification'])){

	  	   echo '<h4>  <span class="glyphicon glyphicon-user">Logged in: '. $fullname.'</span></h4>';
	   
	   	   }
	   ?>  
	      <div class="row">
	      	
	      	<div class="span12">
	      		
	      		<div class="widget">
						
					<!--<div class="widget-header">
						<i class="icon-th-large"></i>
						<h3 style="text-align:right">3rd Line ART Application Form</h3>
                        
					</div>  /widget-header -->
					
					<div class="widget-content">
						
						<div class="pricing-plans plans-3">
							
<?php
    /*include ('includes/app_form.php');*/
   /* include ('includes/app_patientdetails.php');*/
    /*include ('includes/app_form.php');*/

if(isset($_GET['p'])){ 
 include ('includes/rev_new.php');   
}

if(isset($_POST['submit_facility'])){ 
 include ('includes/app_patientdetails.php');   
}

if(isset($_POST['submit_patD'])){ 
 include ('includes/app_clinic_status.php');   
}

if(isset($_POST['submit_clinicstatus'])){ 
 include ('includes/app_pregnancy.php');   
}

if(isset($_POST['submit_Preg'])){ 
 include ('includes/app_pedriatric.php');   
}

    ?>		
				
					  
				
					</div> <!-- /pricing-plans -->
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->					
				
		    </div> <!-- /span12 -->     	
	      	
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div>
    
</div> <!-- /main -->
    
<?php include ('../includes/footer.php'); ?>   

</body>

</html>
