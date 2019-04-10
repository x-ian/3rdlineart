<?php

if(isset($_GET['update'])){ 
	$update_id = $_POST['id'];

	if(isset($_POST['update_facility'])){ 
		$facilityName= mysqli_real_escape_string($bd,$_POST['facilityName']);
		$location= mysqli_real_escape_string($bd,$_POST['location']);

		$sql_update_facility =  "UPDATE facility ".
		"SET 
		facilityName='$facilityName',
		location='$location'
		WHERE id='$update_id'" ;

		if (mysqli_query($bd, $sql_update_facility)){
			echo '  <div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<p style="color:#000">You have <strong> updated facility </strong>. </p>
		</div>';
		echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?man_facility\">"; 

	}
}

if(isset($_POST['update_drug'])){ 
	$line= mysqli_real_escape_string($bd,$_POST['line']);
	$drug_name= mysqli_real_escape_string($bd,$_POST['drug_name']);
	$description= mysqli_real_escape_string($bd,$_POST['description']);

	$sql_update_drugs =  "UPDATE drugs ".
	"SET 
	line='$line',
	drug_name='$drug_name',
	description='$description'
	WHERE id='$update_id'" ;

	if (mysqli_query($bd, $sql_update_drugs)){
		echo '<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#000">You have <strong> updated drug </strong>. </p>
	</div>';
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?man_drugs\">"; 

}
}  

if(isset($_POST['update_affliate'])){ 
	$partner_org_name= mysqli_real_escape_string($bd,$_POST['partner_org_name']);

	$sql_update_partner_org =  "UPDATE partner_org ".
	"SET 
	partner_org_name='$partner_org_name'
	WHERE id='$update_id'" ;

	if (mysqli_query($bd, $sql_update_partner_org)){
		echo '  <div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#000">You have <strong> updated Organization </strong>. </p>
	</div>';
	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?man_affliates\">"; 

}

} 

}

?>