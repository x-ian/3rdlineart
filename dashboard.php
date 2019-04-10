<?php 
 session_start();
 global $now,$expire,$user_id;
 if (isset($_SESSION['identification'])){

	
    global  $fname;
       $fname= $_SESSION['username'];
      /* $lname= $_SESSION['lname'];*/
       $user_id=$_SESSION['identification'];
	   $now = time(); 
	   $expire= $_SESSION['expire'];}
	   
	   ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Dashboard - 3rd Line ART Expert Committee Malawi</title>
<?php 
    
include ('includes/head.php');
    
    ?>
</head>
<body>
<?php
    include ('includes/nav_main.php');
    include ('includes/nav_sub.php');
    
    ?>

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
       
          <?Php
if (isset($_SESSION['identification'])){

       global  $fname;
       $fname= $_SESSION['username'];
      /* $lname= $_SESSION['lname'];*/
  
       
	  	   echo '<h4>  <span class="glyphicon glyphicon-user"> '. $fname.'</span></h4>';
	   
	   	   }
	   ?>  
          
       <div class="span6">
           <div class="widget">
            <div class="widget-header"> <!--<i class="icon-bookmark"></i>-->
              <h3>Tasks</h3>
            </div>

    
            <div class="widget-content">
              <div class="shortcuts">
                  
                  <a href="app.php?p=init" class="shortcut">
                      <i class="shortcut-icon icon-list-alt"></i><span   class="shortcut-label">New Form</span>
                  </a>
                  <a href="javascript:;" class="shortcut">
                      <i class="shortcut-icon icon-bookmark"></i><span class="shortcut-label">Expert Reviews</span> 
                  </a>
                  <a href="javascript:;" class="shortcut">
                      <i class="shortcut-icon icon-signal"></i> <span class="shortcut-label">Reports</span> 
                  </a>
                  <a href="javascript:;" class="shortcut">
                      <i class="shortcut-icon icon-user"></i><span class="shortcut-label">Users</span> 
                  </a> 
                  
                </div>
            </div>
          </div>
          </div>     
          
          
          <div class="span6">
           <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Basic Stats</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  
                    <h6 class="bigstats">A fully responsive premium quality admin template built on Twitter Bootstrap by <a href="http://www.egrappler.com" target="_blank">EGrappler.com</a>.  These are some dummy lines to fill the area.</h6>
                    
                  
                    ...content here.
                    
                    
                </div>
                <!-- /widget-content --> 
                
              </div>
            </div>
          </div>
          </div>
          content here,,,,
          
          
   <?php

   /*$receiver ='j.dumisani7291@gmail.com';
   $to = $receiver;
   $subject = "hello asikana";
   $message = 'you know how we do it'; 
   $header = "From:dumi_ndhlovu@lighthouse.org.mw\r\n";
   $header .= "Cc:dumi_ndhlovu@lighthouse.org.mw\r\n";
   $header .= "MIME-Version: 1.0\r\n";
   $header .= "Content-type: text/html\r\n";
   $retval = mail ($to,$subject,$message,$header);
	*/
	?>   
          
            
      </div>
    </div>
  </div>
</div>


 <?php include ('includes/footer.php'); ?>   
    
<!-- /footer --> 
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>
</body>
</html>
