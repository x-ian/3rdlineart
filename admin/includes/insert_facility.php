<?php

if(isset($_POST['register_facility'])){ 
	
	$facilityName= mysqli_real_escape_string($bd, $_POST['facilityName']);
	$location= mysqli_real_escape_string($bd, $_POST['location']);
	
	
	
	$date_created= date('d/m/Y');
	
	$find_facilityName=mysqli_query($bd, "SELECT * FROM facility where facilityName='$facilityName'"); 
	$getfacilityName = mysqli_num_rows ($find_facilityName);
	
	
	if ($getfacilityName > 0){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Sorry</strong> facility Name already exists </p>
		
	</div>
	';
	
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?man_facility\">"; 
}
else {
	
	
	
	$insert_facility=" INSERT  INTO  facility
	(facilityName,location,date_created)
	VALUES (
	'$facilityName', '$location', '$date_created')";

	mysqli_query($bd, $insert_facility);
	
	echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Success!</strong> New facility Name was added.
	</div>
	';
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?man_facility\">"; 
}
}



?>