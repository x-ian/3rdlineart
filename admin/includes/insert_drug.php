<?php

if(isset($_POST['register_drug'])){ 
	
	$drug_name= mysqli_real_escape_string($bd, $_POST['drug_name']);
	$regimen_line= mysqli_real_escape_string($bd, $_POST['line']);
	$description= mysqli_real_escape_string($bd, $_POST['description']);
	
	
	$date_created= date('d/m/Y');
	
	$find_drugs=mysqli_query($bd, "SELECT * FROM drugs where drug_name='$drug_name'"); 
	$getdrugs = mysqli_num_rows ($find_drugs);
	
	
	if ($getdrugs > 0){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Sorry</strong> Drug already exists </p>
		
	</div>
	';
	
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?man_drugs\">"; 
}
else {
	
	
	
	$insert_drugs=" INSERT  INTO  drugs
	(drug_name,line,description,date_created)
	VALUES (
	'$drug_name', '$regimen_line', '$description','$date_created')";

	mysqli_query($bd, $insert_drugs);
	
	echo '							
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Success!</strong> New drug was added.
	</div>
	';
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?man_drugs\">"; 
}
}



?>