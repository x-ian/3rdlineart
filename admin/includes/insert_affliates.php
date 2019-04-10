<?php

if(isset($_POST['register_affliate'])){ 	
	$partner_org_name= mysqli_real_escape_string($bd, $_POST['partner_org_name']);
	$date_created= date('d/m/Y');
	$find_partner_org_name=mysqli_query($bd, "SELECT * FROM partner_org where partner_org_name='$partner_org_name'"); 
	$getpartner_org_name = mysqli_num_rows ($find_partner_org_name);

	if ($getpartner_org_name > 0){
		echo '<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<p style="color:#f00"><strong>Sorry</strong>  Name already exists </p>

	</div>
	';

	echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?man_affliates\">"; 
	}
	else {
		$insert_partner_org=" INSERT  INTO  partner_org
		(partner_org_name,date_created)
		VALUES (
		'$partner_org_name', '$date_created')";

		mysqli_query($bd, $insert_partner_org);
		echo '							
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Success!</strong> New Name was added.
		</div>
		';
		echo"<meta http-equiv=\"Refresh\" content=\"2; url=dash.php?man_affliates\">"; 
	}
}
?>