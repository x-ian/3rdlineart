<?Php
if (isset($_SESSION['identification'])){

       global  $fullname;
       $fname= $_SESSION['fname'];
       $lname= $_SESSION['lname'];
    $fullname= $fname.' '. $lname;
       
	  	   echo '<h4>  <span class="glyphicon glyphicon-user"> '. $fullname.'</span></h4>';
	   
	   	   }
	   ?>   