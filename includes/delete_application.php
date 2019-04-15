<?php

if(isset($_GET['del_application'])) { 
	error_log('XXXXXXXX');
	$patient_id = $_GET['patient_id'];
	$form_id = $_GET['id'];
	$reload = $_GET['page'];
	
	$sql_app = "DELETE FROM form_creation WHERE 3rdlineart_form_id =$form_id";
	$sql_pat = "DELETE FROM patient WHERE id =$patient_id";
	if (mysqli_query($bd, $sql_app)) {
		if (mysqli_query($bd, $sql_pat)){
			echo '<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<p style="color:#f00">You have <strong> deleted </strong> the Application. </p>	   
			</div>
			';
	    } else {
	    	error_log(mysqli_error($bd));
		}
    } else {
		error_log(mysqli_error($bd));
	}

echo "<meta http-equiv=\"Refresh\" content=\"2; url=app.php?part_1\">"; 
}

?>